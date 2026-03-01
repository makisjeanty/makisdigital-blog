<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
        ]);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Painel Administrativo');
    }

    public function test_regular_user_sees_student_dashboard_not_admin_panel(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_USER,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Minha Área do Aluno');
        $response->assertDontSee('Painel Administrativo');
    }

    public function test_aluno_sees_student_dashboard_not_admin_panel(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ALUNO,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertOk();
        $response->assertSee('Minha Área do Aluno');
        $response->assertDontSee('Painel Administrativo');
    }
}
