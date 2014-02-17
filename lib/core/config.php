<?php

/**
 * Class Config
 */
abstract class Config
{
    const PHP_EXT = '.php';

    private $error_file;

    /**
     * Register all files in directory with extension $ext
     * @param $path
     * @param string $ext
     */
    final protected function registerDir($path, $ext = self::PHP_EXT)
    {
        foreach (glob(ROOT_DIR . $path . '/*' . $ext) as $filename) {
            $this->requireFile($filename);
        }
    }

    /**
     * Require specific file
     * @param $filename
     * @throws Exception
     */
    final protected function requireFile($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception('Filename ' . $filename . ' not found.');
        }
        require_once($filename);
    }

    /**
     * Define custom error file
     * @param $filename
     * @return $this
     */
    public function setErrorFile($filename)
    {
        if (file_exists($filename)) {
            $this->error_file = $filename;
        }
        return $this;
    }

    /**
     * Get defined error file
     * @return mixed
     */
    public function getErrorFile()
    {
        return $this->error_file;
    }

    /**
     * Setup configuration settings
     */
    abstract public function setup();
}