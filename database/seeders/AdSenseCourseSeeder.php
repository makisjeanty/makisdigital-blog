<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdSenseCourseSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::updateOrCreate(
            ['slug' => Str::slug('Formation Complète Google AdSense')],
            [
                'title' => 'Formation Complète Google AdSense',
                'excerpt' => 'Maîtriser Google AdSense de A à Z et construire un sistema rentable basé sur le trafic organique.',
                'description' => 'Formation structurée pour maîtriser Google AdSense de A à Z et construire um sistema rentable basé sur le trafic organique. Durée totale : 20 heures.',
                'level' => 'intermediate',
                'price' => 497.00,
                'duration' => '20h',
                'status' => 'published',
            ]
        );

        // Clear existing modules to avoid duplicates on re-run
        $course->modules()->delete();

        $modules = [
            'Introduction & Modèle Économique',
            'Mentalité & Stratégie Long Terme',
            'Choisir une Niche Rentable',
            'Recherche de Mots-Clés Avancée',
            'Création du Site Professionnel',
            'SEO Fondamental',
            'Rédaction d’Articles Rentables',
            'Production de Contenu en Série',
            'Validation Google AdSense',
            'Placement des Annonces & Optimisation',
            'Augmenter le Trafic Gratuit',
            'Analyse & Optimisation des Revenus',
            'Stratégie Pays Premium',
            'Diversification & Scaling',
            'Plan d’Action 90 Jours',
        ];

        foreach ($modules as $index => $moduleTitle) {
            CourseModule::create([
                'course_id' => $course->id,
                'title' => '🧩 MODULE '.($index + 1).' — '.$moduleTitle,
                'order' => $index + 1,
            ]);
        }
    }
}
