<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;

class GrowthAgent implements AgentInterface
{
    public static function key(): string
    {
        return 'growth';
    }

    public function label(): string
    {
        return 'Growth Agent';
    }

    public function responsibilities(): array
    {
        return [
            'Transformar post em roteiro de video',
            'Criar threads',
            'Criar script para shorts',
            'Planejar calendario mensal',
        ];
    }

    public function skills(): array
    {
        return [
            'Reaproveitamento de conteudo',
            'Estrategia multiplataforma',
            'Planejamento editorial',
        ];
    }

    public function run(array $payload = []): array
    {
        $coreTopic = (string) ($payload['topic'] ?? 'Tema de crescimento');

        return [
            'agent' => self::key(),
            'label' => $this->label(),
            'topic' => $coreTopic,
            'responsibilities' => $this->responsibilities(),
            'skills' => $this->skills(),
            'deliverables' => [
                'repurposing' => [
                    'youtube_script' => 'Abertura, 3 aprendizados, CTA',
                    'thread' => 'Hook + 7 pontos + CTA final',
                    'shorts' => '3 cortes de 30-45 segundos',
                ],
                'calendar' => [
                    'weekly_posts' => 2,
                    'weekly_shorts' => 3,
                    'weekly_threads' => 2,
                ],
            ],
        ];
    }
}
