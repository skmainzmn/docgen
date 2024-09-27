<?php

declare(strict_types=1);

namespace Irlix\Docgen;

use Illuminate\Support\ServiceProvider;
use Irlix\Docgen\Console\DocGenerate;

class IrlixDocgenProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/docgen.php' => config_path('docgen.php')
        ], 'config');

        $this->registerCommands();
    }

    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DocGenerate::class,
            ]);
        }
    }
}
