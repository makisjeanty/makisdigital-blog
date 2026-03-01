<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tecnologia', 'slug' => 'tecnologia'],
            ['name' => 'Negócios', 'slug' => 'negocios'],
            ['name' => 'Inovação', 'slug' => 'inovacao'],
            ['name' => 'Desenvolvimento', 'slug' => 'desenvolvimento'],
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Web Design', 'slug' => 'web-design'],
            ['name' => 'AI', 'slug' => 'ai'],
        ];

        foreach ($tags as $tag) {
            \App\Models\Tag::updateOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}
