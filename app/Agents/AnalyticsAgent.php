<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;

class AnalyticsAgent implements AgentInterface
{
    public static function key(): string
    {
        return 'analytics';
    }

    public function label(): string
    {
        return 'Analytics Agent';
    }

    public function responsibilities(): array
    {
        return [
            'Ler dados do Google Analytics',
            'Cruzar dados com receita',
            'Identificar conteudos com potencial de escala',
            'Sugerir novos clusters',
        ];
    }

    public function skills(): array
    {
        return [
            'Data analysis',
            'Interpretacao de metricas',
            'Deteccao de padrao',
            'Forecast simples',
        ];
    }

    public function run(array $payload = []): array
    {
        $window = (string) ($payload['time_window'] ?? '30d');

        return [
            'agent' => self::key(),
            'label' => $this->label(),
            'time_window' => $window,
            'responsibilities' => $this->responsibilities(),
            'skills' => $this->skills(),
            'deliverables' => [
                'insights' => [
                    'top_metric' => 'Tempo medio na pagina',
                    'anomaly' => 'Queda de CTR em paginas com carregamento lento',
                ],
                'cluster_suggestions' => [
                    'IA para pequenos negocios',
                    'Automacao de marketing com baixo custo',
                    'Monetizacao com AdSense para iniciantes',
                ],
                'forecast' => [
                    'expected_sessions_growth' => '8-12% no proximo ciclo',
                ],
            ],
        ];
    }
}
