<?php

namespace Laswagger\Providers;

use Illuminate\Support\ServiceProvider;
use Laswagger\Swagger\SwaggerOption;
use Laswagger\Swagger\SwaggerGenerator;
use Laswagger\Console\Commands\GenerateDocsCommand;

/**
 * Swagger service provider.
 */
abstract class SwaggerServiceProvider extends ServiceProvider
{
    /**
     * Configure
     *
     * @return void
     */
    abstract protected function configure();

    /**
     * Route
     *
     * @return void
     */
     abstract protected function route();

    /**
     * boot process
     */
    public function boot()
    {
        $this->configure();
        $this->route();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/laswagger.php', 'laswagger');

        $this->app->singleton(SwaggerOption::class, function() {
            return new SwaggerOption(
                config('laswagger.api.directories'),
                config('laswagger.api.excludes'),
                config('laswagger.api.host')
            );
        });
        $this->app->singleton(SwaggerGenerator::class, SwaggerGenerator::class);
        $this->app->singleton(GenerateDocsCommand::class, GenerateDocsCommand::class);

        $this->commands(GenerateDocsCommand::class);
    }
}
