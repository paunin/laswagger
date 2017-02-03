<?php

namespace Laswagger\Providers;

use Laravel\Lumen\Application;

/**
 * Integrate laswagger into a Lumen application.
 *
 * @property Application $app Lumen application.
 */
class LumeSwaggerServiceProvider extends SwaggerServiceProvider
{

    /**
     * Configure
     */
    protected function configure()
    {
        $this->app->configure('laswagger');
    }

    /**
     * Route
     */
    protected function route()
    {
        $this->app->group(
            [
                'namespace' => 'Laswagger\Http\Controllers',
                'prefix'    => config('laswagger.routes.prefix')
            ],
            function (Application $app) {
                $app->get('/api-docs', ['as' => 'swagger-ai-docs', 'uses' => 'SwaggerController@index']);
            }
        );
    }
}
