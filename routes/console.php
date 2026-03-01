<?php

use App\Agents\AgentRegistry;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('agents:list', function (AgentRegistry $registry) {
    $this->info('Registered agents:');

    foreach ($registry->all() as $key => $agent) {
        $this->line("- {$key}: {$agent->label()}");
    }
})->purpose('List registered blog educational agents');
