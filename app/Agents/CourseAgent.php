<?php

namespace App\Agents;

use App\Agents\Contracts\AgentInterface;

class CourseAgent implements AgentInterface
{
    public static function key(): string
    {
        return 'course';
    }

    public function label(): string
    {
        return 'Course Agent';
    }

    public function responsibilities(): array
    {
        return [
            'Estruturacao modular de curso',
            'Progressao didatica',
            'Geracao de exercicios',
            'Criacao de certificados',
            'Sugestao de upsell',
        ];
    }

    public function skills(): array
    {
        return [
            'Design instrucional',
            'Organizacao curricular',
            'Funil educacional',
            'Retencao de aluno',
        ];
    }

    public function run(array $payload = []): array
    {
        $courseName = (string) ($payload['course_name'] ?? 'Curso Principal');

        return [
            'agent' => self::key(),
            'label' => $this->label(),
            'course_name' => $courseName,
            'responsibilities' => $this->responsibilities(),
            'skills' => $this->skills(),
            'deliverables' => [
                'modules' => [
                    ['title' => 'Fundamentos', 'lessons' => 4],
                    ['title' => 'Aplicacao Guiada', 'lessons' => 5],
                    ['title' => 'Projeto Final', 'lessons' => 3],
                ],
                'assessment' => [
                    'quiz_count' => 3,
                    'project_required' => true,
                    'certificate_rule' => 'Aprovacao >= 70%',
                ],
                'upsell' => [
                    'next_offer' => 'Mentoria avancada',
                    'trigger' => 'Conclusao de 80% do curso',
                ],
            ],
        ];
    }
}
