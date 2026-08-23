<?php

declare(strict_types=1);

namespace AiDevQuickstart\AiDevQuickstart;

use AiDevQuickstart\AiDevQuickstart\Console\InstallCommand;
use Illuminate\Support\ServiceProvider;

class AiDevQuickstartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AiDevQuickstart::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            InstallCommand::class,
        ]);
    }
}
