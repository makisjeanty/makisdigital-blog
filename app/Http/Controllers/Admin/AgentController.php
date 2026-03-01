<?php

namespace App\Http\Controllers\Admin;

use App\Agents\AgentRegistry;
use App\Http\Controllers\Controller;
use App\Models\AgentRun;
use App\Services\AgentRunnerService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use InvalidArgumentException;

class AgentController extends Controller
{
    public function __construct(
        private readonly AgentRegistry $registry,
        private readonly AgentRunnerService $agentRunner
    ) {}

    public function index(): View
    {
        $agents = collect($this->registry->all())
            ->map(fn ($agent, string $key): array => [
                'key' => $key,
                'label' => $agent->label(),
                'responsibilities' => $agent->responsibilities(),
                'skills' => $agent->skills(),
            ])
            ->values();

        $runs = AgentRun::query()
            ->with('user:id,name,email')
            ->latest('id')
            ->paginate(20);

        return view('admin.agents.index', compact('agents', 'runs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'agent_key' => ['required', 'string'],
            'payload_json' => ['nullable', 'string', 'max:50000'],
        ]);

        $payload = $this->decodePayload($validated['payload_json'] ?? '');
        if ($payload === null) {
            return back()
                ->withErrors(['payload_json' => 'Payload JSON inválido. Envie um objeto JSON válido.'])
                ->withInput();
        }

        try {
            $run = $this->agentRunner->execute(
                agentKey: $validated['agent_key'],
                payload: $payload,
                user: $request->user(),
                source: 'admin',
                requestedIp: $request->ip(),
                userAgent: $request->userAgent()
            );
        } catch (InvalidArgumentException) {
            return back()
                ->withErrors(['agent_key' => 'Agente inválido.'])
                ->withInput();
        }

        if ($run->status === 'success') {
            return to_route('admin.agents.index')
                ->with('success', "Agente [{$run->agent_key}] executado com sucesso.");
        }

        return to_route('admin.agents.index')
            ->with('error', "Agente [{$run->agent_key}] executado com falha: {$run->error_message}");
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodePayload(string $payloadJson): ?array
    {
        $trimmed = trim($payloadJson);
        if ($trimmed === '') {
            return [];
        }

        $decoded = json_decode($trimmed, true);

        if (json_last_error() !== JSON_ERROR_NONE || ! is_array($decoded)) {
            return null;
        }

        return $decoded;
    }
}
