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

    private static $instance;
    private static $bundle;
    private $error_file;

    /**
     * @param $bundle
     */
    private function __construct($bundle)
    {
        self::$bundle = (!$bundle) ? self::DEFAULT_BUNDLE : $bundle;
        Request::initialize();
        return self::$instance;
    }

    /**
     * Create project instance
     * @param $bundle
     * @return Project
     */
    public static function create($bundle)
    {
        if (!self::$instance) {
            return new self($bundle);
        }
        return self::$instance;
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
        try {
            $this->setupConfiguration();
            $this->dispatch();
        } catch (Exception $e) {
            $this->buildErrorPage($e);
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
        $this->error_file = $config->getErrorFile();
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
     * Display error page and contents
     * @param Exception $e
     */
    private function buildErrorPage(Exception $e)
    {
        header('HTTP/1.1 500 Internal Server Error', null, 500);
        echo((!file_exists($this->error_file)) ? $this->getErrorPageContent($e) : $e->__toString());
        error_log($e->getMessage());
        exit;
    }

    /**
     * Create error page content
     * @param Exception $exception
     * @return string
     */
    private function getErrorPageContent(Exception $exception) //$exception param can be used in error file view
    {
        ob_start();
        require_once($this->error_file);
        $page = ob_get_contents();
        ob_end_clean();
        return $page;
    }

    /**
     * Create controller class instance
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
