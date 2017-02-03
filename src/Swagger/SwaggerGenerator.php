<?php

namespace Laswagger\Swagger;

use Swagger\Annotations\Swagger;

class SwaggerGenerator
{
    /**
     * @var SwaggerOption
     */
    protected $option;

    /**
     * SwaggerGenerator constructor.
     *
     * @param SwaggerOption $option
     */
    public function __construct(SwaggerOption $option)
    {
        $this->option = $option;
    }

    /**
     *
     * @return SwaggerOption
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * Generate swagger api docs.
     *
     * @return Swagger
     */
    public function generateDocs()
    {
        $swagger = \Swagger\scan(
            $this->option->getDirectories(),
            ['exclude' => $this->option->getExcludeDirs()]
        );
        if($this->option->getHost() !== null) {
            $swagger->host = $this->option->getHost();
        }
        return $swagger;
    }
}
