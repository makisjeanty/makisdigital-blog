<?php

namespace Tests\Feature\Agents;

use App\Models\AgentRun;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAgentExecutionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_execute_agent_from_admin_panel(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.agents.run'), [
            'agent_key' => 'content',
            'payload_json' => '{"topic":"SEO para blogs","audience":"iniciante"}',
        ]);

        $response->assertRedirect(route('admin.agents.index'));

        $this->assertDatabaseHas('agent_runs', [
            'agent_key' => 'content',
            'source' => 'admin',
            'status' => 'success',
            'user_id' => $admin->id,
        ]);
    }

    public function test_invalid_json_payload_returns_validation_error(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->from(route('admin.agents.index'))
            ->actingAs($admin)
            ->post(route('admin.agents.run'), [
                'agent_key' => 'content',
                'payload_json' => '{invalid',
            ]);

        $response->assertRedirect(route('admin.agents.index'));
        $response->assertSessionHasErrors('payload_json');
        $this->assertDatabaseCount((new AgentRun)->getTable(), 0);
    }
}
