<?php

namespace Laswagger\Console\Commands;

use Illuminate\Console\Command;
use Laswagger\Swagger\SwaggerGenerator;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Generate docs command
 */
class GenerateDocsCommand extends Command
{
    /**
     * The swagger api docs generator.
     *
     * @var SwaggerGenerator
     */
    protected $swaggerGenerator;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'swagger:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate docs';

    /**
     * GenerateDocsCommand constructor.
     *
     * @param SwaggerGenerator $swagger
     */
    public function __construct(SwaggerGenerator $swagger)
    {
        $this->swaggerGenerator = $swagger;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('swagger:generate')
            ->setDescription('Generate json for swagger')
            ->addArgument(
                'file_name',
                InputArgument::REQUIRED,
                'Output file'
            )
            ->addArgument(
                'base_host',
                InputArgument::OPTIONAL,
                'Base host in generated file'
            );
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $host = $this->argument('base_host');
        $file = $this->argument('file_name');

        $this->info('Regenerating docs');

        if ($host) {
            $this->swaggerGenerator->getOption()->setHost($host);
        }
        $this->swaggerGenerator->generateDocs()->saveAs($file);
    }
}
