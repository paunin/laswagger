<?php

namespace Laswagger\Test;

use Laravel\Lumen\Application;
use Laravel\Lumen\Testing\TestCase;
use Laswagger\Providers\LumeSwaggerServiceProvider;

class LumenApplicationTest extends TestCase
{

    /**
     * @var \Illuminate\Contracts\Console\Kernel
     */
    protected $consoleKernel;

    /**
     * @inheritdoc
     */
    public function createApplication()
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        $app = new Application(realpath(__DIR__));

        $app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Laravel\Lumen\Exceptions\Handler::class
        );

        $app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \Laswagger\Test\ConsoleKernel::class
        );

        $this->consoleKernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

        $app->register(LumeSwaggerServiceProvider::class);

        return $app;
    }

    /**
     * @return array
     */
    public function controllerProvider()
    {
        return [
            [
                [__DIR__ . '/annotations/test1.php'],
                [
                    'swagger' => '2.0',
                    'info'    => [
                        'title'       => 'Test laswagger API docs',
                        'description' => 'Test laswagger API docs',
                        'version'     => '1.0',
                    ],
                    'host'    => 'localhost',
                    'schemes' => [
                        'http',
                        'https'
                    ],
                    'definitions' => [],
                    'paths'   => [
                        '/' => [
                            'get' => [
                                'tags'        => [
                                    'Test'
                                ],
                                'summary'     => 'Test api',
                                'description' => 'Test api',
                                'produces'    => [
                                    'application/json'
                                ],
                                'responses'   => [
                                    '200' => [
                                        'description' => 'OK'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * Test swagger controller
     *
     * @dataProvider controllerProvider
     */
    public function testController($directories, $expected)
    {
        $this->app['config']->set('laswagger.api.directories', $directories);
        $this->app['config']->set('laswagger.api.host', 'localhost');
        $this->get('/swagger/api-docs');

        $this->assertResponseOk();

        $this->assertEquals($expected, json_decode($this->response->getContent(), true));

    }


    /**
     * @return array
     */
    public function controllerWithCorsProvider()
    {
        return [
            [
                [__DIR__ . '/annotations/test1.php'],
                [
                    'access-control-allow-methods' => ['GET'],
                    'access-control-allow-headers' => ['Content-Type'],
                    'access-control-allow-origin'  => ['*'],
                ]
            ]
        ];
    }

    /**
     * Test cors enabled
     *
     * @dataProvider controllerWithCorsProvider
     *
     * @param $directories
     */
    public function testControllerWithCors($directories, $expected)
    {
        $this->app['config']->set('laswagger.api.directories', $directories);
        $this->app['config']->set('laswagger.routes.cors', true);
        $this->get('/swagger/api-docs');

        $this->assertArraySubset($expected, $this->response->headers->all());
    }

    /**
     * Test generate docs command
     *
     * @dataProvider controllerProvider
     *
     * @param $directories
     * @param $expected
     */
    public function testGeneratorDocsCommand($directories, $expected)
    {
        $output = '/tmp/swagger.json';
        if (file_exists($output)) {
            unlink($output);
        }
        $this->app['config']->set('laswagger.api.directories', $directories);

        $this->consoleKernel->call('swagger:generate', ['file_name' => $output, 'base_host' => 'localhost']);

        $this->assertArraySubset($expected, json_decode(file_get_contents($output), true));

        unlink($output);
    }

}
