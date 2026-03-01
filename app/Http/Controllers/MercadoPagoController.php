<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MercadoPagoController extends Controller
{
    protected function apiBaseUrl(): string
    {
        return 'https://api.mercadopago.com';
    }

    protected function accessToken(): string
    {
        return (string) config('services.mercadopago.access_token');
    }

    protected function apiRequest(string $method, string $path, array $payload = []): array
    {
        $token = $this->accessToken();
        if ($token === '') {
            throw new \RuntimeException('Mercado Pago access token not configured');
        }

        $request = Http::baseUrl($this->apiBaseUrl())
            ->acceptJson()
            ->asJson()
            ->withToken($token)
            ->timeout(15);

        $response = match (strtoupper($method)) {
            'GET' => $request->get($path, $payload),
            'POST' => $request->post($path, $payload),
            default => throw new \InvalidArgumentException('Unsupported HTTP method'),
        };

        $response->throw();

        return (array) $response->json();
    }

    protected function createPreference(array $payload): array
    {
        return $this->apiRequest('POST', '/checkout/preferences', $payload);
    }

    protected function getPayment(string $paymentId): array
    {
        return $this->apiRequest('GET', "/v1/payments/{$paymentId}");
    }

    /**
     * Resolve course/user context from payment payload with defensive fallbacks.
     */
    protected function resolvePaymentContext(array $payment): array
    {
        $courseId = 0;
        $userId = 0;

        $externalReference = $payment['external_reference'] ?? null;
        if (is_string($externalReference) && $externalReference !== '') {
            $ref = json_decode($externalReference, true);
            if (is_array($ref)) {
                $courseId = (int) ($ref['course_id'] ?? 0);
                $userId = (int) ($ref['user_id'] ?? 0);
            }
        }

        $metadata = is_array($payment['metadata'] ?? null) ? $payment['metadata'] : [];
        if ($courseId === 0) {
            $courseId = (int) ($metadata['course_id'] ?? 0);
        }
        if ($userId === 0) {
            $userId = (int) ($metadata['user_id'] ?? 0);
        }

        if ($courseId === 0) {
            $courseId = (int) data_get($payment, 'additional_info.items.0.id', 0);
        }

        if ($userId === 0) {
            $payerEmail = (string) data_get($payment, 'payer.email', '');
            if ($payerEmail !== '') {
                $userId = (int) User::where('email', $payerEmail)->value('id');
            }
        }

        return [$courseId, $userId];
    }

    /**
     * Create a Mercado Pago Checkout preference and redirect.
     */
    public function checkout(Course $course)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $webhookToken = (string) config('services.mercadopago.webhook_token');

        // If already enrolled
        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course->slug)
                ->with('info', 'Você já está matriculado neste curso.');
        }

        // Free course
        if ($course->price <= 0) {
            $user->courses()->syncWithoutDetaching([$course->id]);

            return redirect()->route('dashboard')
                ->with('success', 'Acesso liberado!');
        }

        if ($webhookToken === '') {
            Log::error('Mercado Pago webhook token not configured');

            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Configuração de pagamento indisponível.');
        }

        try {
            $preference = $this->createPreference([
                'items' => [
                    [
                        'id' => (string) $course->id,
                        'title' => $course->title,
                        'description' => $course->excerpt ?? 'Curso online - Makis Digital',
                        'quantity' => 1,
                        'currency_id' => 'BRL',
                        'unit_price' => (float) $course->price,
                    ],
                ],
                'payer' => [
                    'email' => $user->email,
                    'name' => $user->name,
                ],
                'back_urls' => [
                    'success' => route('mercadopago.success', $course),
                    'failure' => route('courses.show', $course->slug),
                    'pending' => route('mercadopago.pending', $course),
                ],
                'auto_return' => 'approved',
                'external_reference' => json_encode([
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ]),
                'metadata' => [
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                ],
                'notification_url' => route('mercadopago.webhook', ['token' => $webhookToken]),
            ]);
        } catch (\Throwable $e) {
            Log::error('Mercado Pago checkout failed: '.$e->getMessage(), [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);

            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Não foi possível iniciar o pagamento.');
        }

        $initPoint = $preference['init_point'] ?? null;
        if (! is_string($initPoint) || $initPoint === '') {
            Log::error('Mercado Pago checkout response missing init_point', [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]);

            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Resposta de pagamento inválida.');
        }

        return redirect($initPoint);
    }

    /**
     * Handle successful payment return.
     */
    public function success(Course $course, Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $paymentId = $request->query('payment_id') ?? $request->query('collection_id');

        if (! $paymentId) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Retorno de pagamento inválido.');
        }

        try {
            $payment = $this->getPayment((string) $paymentId);
            $isApproved = ($payment['status'] ?? null) === 'approved';
            [$metaCourseId, $metaUserId] = $this->resolvePaymentContext($payment);

            if (! $isApproved || $metaCourseId !== $course->id || $metaUserId !== $user->id) {
                Log::warning('Mercado Pago success rejected due to metadata/status mismatch', [
                    'course_id' => $course->id,
                    'user_id' => $user->id,
                    'payment_id' => $paymentId,
                    'payment_status' => $payment['status'] ?? null,
                    'meta_course_id' => $metaCourseId,
                    'meta_user_id' => $metaUserId,
                ]);

                return redirect()->route('courses.show', $course->slug)
                    ->with('error', 'Pagamento não confirmado.');
            }
        } catch (\Throwable $e) {
            Log::warning('Mercado Pago success validation failed: '.$e->getMessage(), [
                'course_id' => $course->id,
                'user_id' => $user->id,
                'payment_id' => $paymentId,
            ]);

            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Não foi possível validar o pagamento.');
        }

        // Enroll user
        $user->courses()->syncWithoutDetaching([$course->id]);

        // Upgrade role
        if ($user->role === \App\Models\User::ROLE_USER) {
            $user->role = \App\Models\User::ROLE_ALUNO;
            $user->save();
        }

        return redirect()->route('dashboard')
            ->with('success', 'Pagamento aprovado! Você tem acesso ao curso: '.$course->title);
    }

    /**
     * Handle pending payment.
     */
    public function pending(Course $course)
    {
        return redirect()->route('courses.show', $course->slug)
            ->with('info', 'Seu pagamento está pendente. Assim que for confirmado, você terá acesso ao curso.');
    }

    /**
     * Handle Mercado Pago IPN webhook.
     */
    public function webhook(Request $request)
    {
        $expectedToken = (string) config('services.mercadopago.webhook_token');
        $receivedToken = (string) $request->query('token', '');
        if ($expectedToken === '' || ! hash_equals($expectedToken, $receivedToken)) {
            Log::warning('Mercado Pago webhook rejected due to invalid token');

            return response()->json(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        $type = $request->input('type') ?: $request->input('topic');

        if ($type === 'payment') {
            $paymentId = $request->input('data.id');
            if (! $paymentId) {
                $paymentId = $request->input('id');
            }

            try {
                $payment = $this->getPayment((string) $paymentId);

                if (($payment['status'] ?? null) === 'approved') {
                    [$courseId, $userId] = $this->resolvePaymentContext($payment);

                    if ($userId && $courseId) {
                        $user = \App\Models\User::find($userId);
                        $course = Course::find($courseId);

                        if ($user && $course) {
                            $user->courses()->syncWithoutDetaching([$course->id]);

                            if ($user->role === \App\Models\User::ROLE_USER) {
                                $user->role = \App\Models\User::ROLE_ALUNO;
                                $user->save();
                            }

                            Log::info("MP: User {$user->email} enrolled in {$course->title}");
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('MP Webhook error: '.$e->getMessage());
            }
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
