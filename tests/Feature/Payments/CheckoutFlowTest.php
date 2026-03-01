<?php

namespace Tests\Feature\Payments;

use App\Http\Controllers\MercadoPagoController;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class CheckoutFlowTest extends TestCase
{
    public function test_mercadopago_success_enrolls_user_when_payment_is_valid(): void
    {
        $course = new Course([
            'title' => 'Curso MP',
            'slug' => 'curso-mp',
        ]);
        $course->id = 50;

        $relation = Mockery::mock(BelongsToMany::class);
        $relation->shouldReceive('syncWithoutDetaching')->once()->with([$course->id]);

        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 60;
        $user->email = 'mp@example.com';
        $user->role = User::ROLE_USER;
        $user->shouldReceive('courses')->andReturn($relation);
        $user->shouldReceive('save')->once()->andReturn(true);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $payment = [
            'status' => 'approved',
            'external_reference' => json_encode([
                'course_id' => $course->id,
                'user_id' => $user->id,
            ]),
        ];

        $controller = Mockery::mock(MercadoPagoController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('getPayment')->once()->with('123')->andReturn($payment);

        $request = Request::create('/mercadopago/curso-mp/sucesso', 'GET', [
            'payment_id' => '123',
        ]);

        $response = $controller->success($course, $request);

        $this->assertSame(route('dashboard'), $response->getTargetUrl());
    }

    public function test_mercadopago_success_rejects_when_payment_id_is_missing(): void
    {
        $course = new Course([
            'title' => 'Curso MP',
            'slug' => 'curso-mp',
        ]);
        $course->id = 50;

        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 60;
        $user->role = User::ROLE_USER;
        $user->shouldReceive('courses')->never();
        $user->shouldReceive('save')->never();

        Auth::shouldReceive('user')->once()->andReturn($user);

        $controller = Mockery::mock(MercadoPagoController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('getPayment')->never();

        $request = Request::create('/mercadopago/curso-mp/sucesso', 'GET');

        $response = $controller->success($course, $request);

        $this->assertSame(route('courses.show', $course->slug), $response->getTargetUrl());
    }

    public function test_mercadopago_success_enrolls_user_when_external_reference_is_missing_but_metadata_is_present(): void
    {
        $course = new Course([
            'title' => 'Curso MP',
            'slug' => 'curso-mp',
        ]);
        $course->id = 70;

        $relation = Mockery::mock(BelongsToMany::class);
        $relation->shouldReceive('syncWithoutDetaching')->once()->with([$course->id]);

        $user = Mockery::mock(User::class)->makePartial();
        $user->id = 80;
        $user->email = 'mp-meta@example.com';
        $user->role = User::ROLE_USER;
        $user->shouldReceive('courses')->andReturn($relation);
        $user->shouldReceive('save')->once()->andReturn(true);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $payment = [
            'status' => 'approved',
            'external_reference' => null,
            'metadata' => [
                'course_id' => $course->id,
                'user_id' => $user->id,
            ],
        ];

        $controller = Mockery::mock(MercadoPagoController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('getPayment')->once()->with('456')->andReturn($payment);

        $request = Request::create('/mercadopago/curso-mp/sucesso', 'GET', [
            'payment_id' => '456',
        ]);

        $response = $controller->success($course, $request);

        $this->assertSame(route('dashboard'), $response->getTargetUrl());
    }
}
