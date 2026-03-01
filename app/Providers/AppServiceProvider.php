<?php

namespace App\Providers;

use App\Agents\AnalyticsAgent;
use App\Agents\AgentRegistry;
use App\Agents\ContentAgent;
use App\Agents\CourseAgent;
use App\Agents\GrowthAgent;
use App\Agents\MonetizationAgent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AgentRegistry::class, fn ($app) => new AgentRegistry(
            $app->make(ContentAgent::class),
            $app->make(CourseAgent::class),
            $app->make(MonetizationAgent::class),
            $app->make(AnalyticsAgent::class),
            $app->make(GrowthAgent::class),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        \Illuminate\Pagination\Paginator::useTailwind();

        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
