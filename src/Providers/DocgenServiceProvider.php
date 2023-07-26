<?php

namespace Skmainzmn\Docgen\Providers;

use Illuminate\Support\ServiceProvider;
use Skmainzmn\Docgen\Console\Commands\DocGenerate;

class DocgenServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/docgen.php' => config_path('docgen.php')
            ]);

            $this->commands([
                DocGenerate::class,
            ]);
        }
    }
}
