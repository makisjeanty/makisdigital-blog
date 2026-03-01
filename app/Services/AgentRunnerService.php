<?php

namespace App\Services;

use App\Agents\AgentRegistry;
use App\Models\AgentRun;
use App\Models\User;
use Throwable;

class AgentRunnerService
{
    public function __construct(
        private readonly AgentRegistry $registry
    ) {}

    /**
     * @param  array<string, mixed>  $payload
     */
    public function execute(
        string $agentKey,
        array $payload = [],
        ?User $user = null,
        string $source = 'api',
        ?string $requestedIp = null,
        ?string $userAgent = null
    ): AgentRun {
        $agent = $this->registry->get($agentKey);
        $status = 'success';
        $result = null;
        $error = null;

        try {
            $result = $agent->run($payload);
        } catch (Throwable $e) {
            $status = 'failed';
            $error = $e->getMessage();
        }

        return AgentRun::create([
            'user_id' => $user?->id,
            'agent_key' => $agentKey,
            'source' => $source,
            'status' => $status,
            'payload' => $payload,
            'result' => $result,
            'error_message' => $error,
            'requested_ip' => $requestedIp,
            'user_agent' => $userAgent,
            'executed_at' => now(),
        ]);
    }
}
