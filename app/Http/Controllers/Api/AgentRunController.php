<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AgentRunnerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AgentRunController extends Controller
{
    public function __construct(
        private readonly AgentRunnerService $agentRunner
    ) {}

    public function store(Request $request, string $agent): JsonResponse
    {
        $validated = $request->validate([
            'payload' => ['nullable', 'array'],
        ]);

        try {
            $run = $this->agentRunner->execute(
                agentKey: $agent,
                payload: $validated['payload'] ?? [],
                user: $request->user(),
                source: 'api',
                requestedIp: $request->ip(),
                userAgent: $request->userAgent()
            );
        } catch (InvalidArgumentException) {
            return response()->json([
                'message' => 'Agent not found.',
                'agent' => $agent,
            ], 404);
        }

        $statusCode = $run->status === 'success' ? 200 : 500;

        return response()->json([
            'id' => $run->id,
            'agent_key' => $run->agent_key,
            'status' => $run->status,
            'result' => $run->result,
            'error_message' => $run->error_message,
            'executed_at' => $run->executed_at?->toIso8601String(),
        ], $statusCode);
    }
}
