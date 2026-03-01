<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default settings
        \Illuminate\Support\Facades\DB::table('settings')->insert([
            ['key' => 'site_name', 'value' => 'Makis Digital'],
            ['key' => 'site_description', 'value' => 'Educação e Tecnologia'],
            ['key' => 'contact_email', 'value' => 'contato@makisdigital.com'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
