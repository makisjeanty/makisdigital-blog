<?php

namespace Tests\Feature\Security;

use Tests\TestCase;

class WebhookSecurityTest extends TestCase
{
    public function test_mercadopago_webhook_requires_token(): void
    {
        config()->set('services.mercadopago.webhook_token', 'token123');

        $response = $this->postJson('/mercadopago/webhook', [
            'type' => 'payment',
            'data' => ['id' => '123'],
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Invalid token']);
    }

    public function test_mercadopago_webhook_rejects_wrong_token(): void
    {
        config()->set('services.mercadopago.webhook_token', 'token123');

        $response = $this->postJson('/mercadopago/webhook?token=wrong-token', [
            'type' => 'payment',
            'data' => ['id' => '123'],
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Invalid token']);
    }

    public function test_removed_diagnostic_routes_are_not_accessible(): void
    {
        $routes = [
            '/stripe/webhook',
            '/migrate',
            '/seed-adsense',
            '/composer-install',
            '/debug-db',
            '/list-tables',
            '/check-columns',
            '/force-soft-delete',
            '/clear-cache',
            '/make-admin/1',
        ];

        foreach ($routes as $route) {
            $this->get($route)->assertNotFound();
        }
    }
}
