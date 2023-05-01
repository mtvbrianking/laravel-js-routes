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
            __DIR__ . '/../config/js-routes.php' => config_path('js-routes.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../resources/js/router.js' => resource_path('js/router.js'),
            __DIR__ . '/../resources/js/router.mjs' => resource_path('js/router.mjs'),
        ], 'resources');

        $this->commands([
            Console\GenerateJsRoutesCommand::class,
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/js-routes.php', 'js-routes');
    }
}
