<?php

namespace Tests\Feature\Agents;

use App\Models\AgentRun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAgentRunTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_requires_access_for_agent_execution(): void
    {
        $this->postJson('/api/agents/content/run', [
            'payload' => ['topic' => 'Teste'],
        ])->assertUnauthorized();
    }

    public function test_api_can_execute_agent_with_valid_api_key(): void
    {
        config()->set('services.agents.api_key', 'test-agent-key');

        $response = $this->withHeader('X-Agent-Key', 'test-agent-key')
            ->postJson('/api/agents/content/run', [
                'payload' => ['topic' => 'SEO Tecnico'],
            ]);

        $response->assertOk()
            ->assertJson([
                'agent_key' => 'content',
                'status' => 'success',
            ]);

        $this->assertDatabaseHas((new AgentRun)->getTable(), [
            'agent_key' => 'content',
            'source' => 'api',
            'status' => 'success',
        ]);
    }

    public function test_api_returns_not_found_for_invalid_agent(): void
    {
        config()->set('services.agents.api_key', 'test-agent-key');

        $this->withHeader('X-Agent-Key', 'test-agent-key')
            ->postJson('/api/agents/inexistente/run', [
                'payload' => [],
            ])
            ->assertNotFound();
    }
}
