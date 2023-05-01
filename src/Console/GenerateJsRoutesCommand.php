<?php

namespace Bmatovu\JsRoutes\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;

/**
 * @see https://ideas.hexbridge.com/how-to-use-laravel-routes-in-javascript-4d9c484a0d97
 * @see https://medium.com/@jonan.pineda/thank-you-for-this-post-d1d32c991757
 */
class GenerateJsRoutesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'js-routes:generate
                                {--p|path=resources/js/routes.json : JS routes file path.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate routes for Javascript.';

    /**
     * Application router.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * File system.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Routing\Router        $router
     * @param \Illuminate\Filesystem\Filesystem $file
     *
     * @return void
     */
    public function __construct(Router $router, Filesystem $file)
    {
        parent::__construct();
        $this->router = $router;
        $this->file = $file;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Generating routes for Javascript...');

        $jsRoutes = collect($this->router->getRoutes())
            ->filter(function ($route) {
                return !$this->matches(config('js-routes.excluded'), $route->uri);
            })
            ->reduce(function ($jsRoutes, $route) {
                $jsRoutes[$route->getName()] = $route->uri;

                return $jsRoutes;
            }, []);

        $path = $this->option('path');

        $this->file->put($path, json_encode($jsRoutes, JSON_PRETTY_PRINT));

        $this->info("Routes saved to '{$path}'.");

        $this->info("Run 'npm run dev' to update routes cache.");
    }

    /**
     * Perform a regular expression match.
     *
     * @param array  $patterns
     * @param string $subject
     *
     * @return bool
     */
    protected function matches($patterns, $subject)
    {
        $isMatched = false;

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $subject)) {
                $isMatched = true;

                break;
            }
        }

        return $isMatched;
    }
}
