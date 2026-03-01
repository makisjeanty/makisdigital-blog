<?php

use App\Http\Controllers\Api\AgentRunController;
use Illuminate\Support\Facades\Route;

Route::middleware(['agent.access', 'throttle:20,1'])->group(function () {
    Route::post('/agents/{agent}/run', [AgentRunController::class, 'store'])
        ->name('api.agents.run');
});
