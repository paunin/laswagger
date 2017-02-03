<?php

namespace Laswagger\Swagger;

/**
 * Class Holding option for swagger generator
 */
class SwaggerOption
{
    /**
     * Directories to scan by swagger
     *
     * @var array
     */
    protected $directories;

    /**
     * Exclude directories
     *
     * @var array
     */
    protected $excludeDirs;

    /**
     * The base host
     *
     * @var string
     */
    protected $host;

    /**
     * SwaggerOption constructor.
     *
     * @param array $directories
     * @param array $excludeDirs
     * @param string $host
     */
    public function __construct(array $directories = [], array $excludeDirs = [], $host = null)
    {
        $this->setDirectory($directories);
        $this->setExcludeDirs($excludeDirs);
        $this->setHost($host);
    }

    /**
     * Directory getter
     *
     * @return array
     */
    public function getDirectories()
    {
        return $this->directories;
    }

    /**
     * Directories setter
     *
     * @param array $directories
     * @return $this
     */
    public function setDirectory($directories)
    {
        $this->directories = $directories;
        return $this;
    }

    /**
     * ExcludeDirs getter
     *
     * @return array
     */
    public function getExcludeDirs()
    {
        return $this->excludeDirs;
    }

    /**
     * ExcludeDirs setter
     *
     * @param array $excludeDirs
     * @return $this
     */
    public function setExcludeDirs($excludeDirs)
    {
        $this->excludeDirs = $excludeDirs;
        return $this;
    }

    /**
     * Host getter
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Host setter
     *
     * @param string $host
     * @return $this
     */
    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }
}
