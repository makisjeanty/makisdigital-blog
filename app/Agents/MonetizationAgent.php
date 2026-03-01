<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;

class MonetizationAgent implements AgentInterface
{
    public static function key(): string
    {
        return 'monetization';
    }

    public function label(): string
    {
        return 'Monetization Agent';
    }

    public function responsibilities(): array
    {
        return [
            'Definir melhor posicao de anuncios',
            'Planejar testes A/B de CTR',
            'Analisar RPM',
            'Mapear paginas com maior receita',
            'Sugerir melhorias de layout para conversao',
        ];
    }

    public function skills(): array
    {
        return [
            'CRO',
            'Analise de metricas',
            'Logica de heatmap',
            'Estrategia de LTV',
        ];
    }

    public function run(array $payload = []): array
    {
        $pageType = (string) ($payload['page_type'] ?? 'post');

        return [
            'agent' => self::key(),
            'label' => $this->label(),
            'page_type' => $pageType,
            'responsibilities' => $this->responsibilities(),
            'skills' => $this->skills(),
            'deliverables' => [
                'ad_slots' => [
                    'hero_below' => 'enabled',
                    'mid_content' => 'enabled',
                    'sidebar' => 'enabled',
                    'footer' => 'enabled',
                ],
                'ab_test' => [
                    'variant_a' => 'Anuncio apos 1o bloco do artigo',
                    'variant_b' => 'Anuncio apos 2o bloco do artigo',
                    'primary_metric' => 'CTR',
                ],
                'recommendations' => [
                    'Evitar excesso de anuncios above the fold',
                    'Manter distancia entre CTA e bloco AdSense',
                ],
            ],
        ];
    }
}
