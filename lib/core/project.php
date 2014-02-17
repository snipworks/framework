<?php

/**
 * Class Project
 */
class Project
{
    const CONTROLLER = 'Controller';
    const UTIL = 'Util';
    const MODEL = 'Model';
    const CONFIG = 'Config';
    const DEFAULT_BUNDLE = 'main';

    private static $bundle;

    /**
     * @param $bundle
     */
    public function __construct($bundle)
    {
        self::$bundle = (!$bundle) ? self::DEFAULT_BUNDLE : $bundle;
        Request::initialize();
    }

    /**
     * Create project instance
     * @param $bundle
     * @return Project
     */
    public static function create($bundle)
    {
        return new self($bundle);
    }

    /**
     * Get defined bundle name
     * @return mixed
     */
    public static function getBundle()
    {
        return self::$bundle;
    }

    /**
     * Build project
     */
    public function build()
    {
        $config = null;
        try {
            $config = $this->setupConfiguration();
            $this->dispatch();
        } catch (Exception $e) {
            if (($config instanceof Config) && !is_null($config->getErrorFile())){
                $this->buildErrorPage($e, $config->getErrorFile());
            } else {
                die($e->__toString());
            }
        }
    }

    /**
     * Set bundle configuration
     */
    private function setupConfiguration()
    {
        $config_name = self::getBundle() . self::CONFIG;
        if (!class_exists($config_name)) {
            throw new Exception('Class ' . $config_name . ' not found.');
        }

        /** @var Config $config */
        $config = new $config_name;
        $config->setup();
        return $config;
    }

    /**
     * Dispatch project settings
     */
    private function dispatch()
    {
        $controller = self::createController(Request::getController());
        $controller->execute(Request::getAction());
    }

    /**
     * Create error page
     * @param Exception $exception
     * @param $error_file
     */
    private function buildErrorPage(Exception $exception, $error_file)
    {
        ob_start();
        require_once($error_file);
        $page = ob_get_clean();
        ob_end_clean();
        echo $page;
    }
    /**
     * @param $controller
     * @return Controller
     * @throws Exception
     */
    private static function createController($controller)
    {
        $controller .= self::CONTROLLER;
        if (!class_exists($controller)) {
            throw new Exception('Class ' . $controller . ' not found.');
        }
        return new $controller;
    }
}
