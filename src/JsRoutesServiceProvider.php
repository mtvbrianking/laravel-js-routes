<?php

namespace Bmatovu\JsRoutes;

use Illuminate\Support\ServiceProvider;

class JsRoutesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/js/router.js' => resource_path('js/router.js'),
        ], 'resources');

        $this->commands([
            Console\GenerateJsRoutesCommand::class,
        ]);
    }
}
