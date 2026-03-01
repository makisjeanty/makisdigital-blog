<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;

class ContentAgent implements AgentInterface
{
    public static function key(): string
    {
        return 'content';
    }

    public function label(): string
    {
        return 'Content Agent';
    }

    public function responsibilities(): array
    {
        return [
            'Pesquisa de palavra-chave',
            'Estrutura de artigo otimizada',
            'Meta title e meta description',
            'Sugestao de interlink',
            'Schema Markup de Article',
            'Sugestao de posicionamento de anuncios',
        ];
    }

    public function skills(): array
    {
        return [
            'SEO tecnico',
            'Copywriting',
            'Clusterizacao de conteudo',
            'Analise de concorrencia',
        ];
    }

    public function run(array $payload = []): array
    {
        $topic = (string) ($payload['topic'] ?? 'Tema principal');
        $audience = (string) ($payload['audience'] ?? 'Publico geral');

        return [
            'agent' => self::key(),
            'label' => $this->label(),
            'topic' => $topic,
            'audience' => $audience,
            'responsibilities' => $this->responsibilities(),
            'skills' => $this->skills(),
            'deliverables' => [
                'keyword_plan' => [
                    'primary_keyword' => $topic,
                    'long_tail_examples' => [
                        $topic.' para iniciantes',
                        $topic.' passo a passo',
                        $topic.' erros comuns',
                    ],
                ],
                'post_structure' => [
                    'h1' => $topic,
                    'h2' => ['Introducao', 'Como aplicar na pratica', 'Checklist final'],
                ],
                'seo_meta' => [
                    'title' => $topic.' | Guia Completo',
                    'description' => 'Aprenda '.$topic.' com exemplos praticos e aplicacao real.',
                ],
            ],
        ];
    }
}
