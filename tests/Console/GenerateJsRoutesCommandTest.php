<?php

namespace Bmatovu\JsRoutes\Tests;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Route;
use Mockery as m;

class GenerateJsRoutesCommandTest extends TestCase
{
    public $jsonRoutesFile = __DIR__.'/../resources/js/routes.json';

    /**
     * {@inherit}
     */
    protected function setUp(): void
    {
        fopen($this->jsonRoutesFile, 'w');

        parent::setUp();
    }

    /**
     * {@inherit}
     */
    protected function tearDown(): void
    {
        // unlink($this->jsonRoutesFile);

        parent::tearDown();
    }

    /**
     * @test
     */
    public function sync_app_routes_to_json()
    {
        // Create sample route...

        Route::name('home')
            ->middleware(['web'])
            ->get('/', function () {
                return response('This could be the home page.');
            });

        // Create dependencies...

        $router = Container::getInstance()->make('router');

        $fileSystem = Container::getInstance()->make('files');

        // Mock command with required dependecies...

        $mockCommand = m::mock('Bmatovu\JsRoutes\Console\GenerateJsRoutesCommand[line]', [$router, $fileSystem])
            ->shouldIgnoreMissing();

        $mockCommand->shouldReceive('line')->with('Generating routes for Javascript.');

        $mockCommand->shouldReceive('line')->with("Routes saved to '{$this->jsonRoutesFile}'.");

        Container::getInstance()->make(Kernel::class)->registerCommand($mockCommand);

        $this->artisan('js-routes:generate', [
            '--path' => $this->jsonRoutesFile,
            '--no-interaction' => true,
        ])->assertExitCode(0);

        $this->assertFileExists($this->jsonRoutesFile);

        $jsonRoutes = file_get_contents($this->jsonRoutesFile);

        $routes = json_decode($jsonRoutes, true);

        $this->assertEquals($routes, [
            'home' => '/',
        ]);
    }
}
