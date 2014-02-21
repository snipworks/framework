<?php

abstract class Request
{
    const DEFAULT_URI = 'index';

    private static $controller;
    private static $action;
    private static $front_controller;

    /**
     * Initialize request parameters
     */
    public static function initialize()
    {
        self::$front_controller = $_SERVER['SCRIPT_NAME'];
        self::parseUri();
    }

    /**
     * Parse request uri to parameters
     */
    private static function parseUri()
    {
        $request_uri = explode('?', $_SERVER['REQUEST_URI'], 2);
        $module = isset($request_uri[0]) ? $request_uri[0] : '';
        $front_controller = self::getFrontController();
        $position = strpos($module, $front_controller);
        if ($position === 0) {
            $module = substr_replace($module, '', $position, strlen($front_controller));
        }
        $module = explode('/', trim($module, '/'));
        $module = array_filter($module);

        self::$controller = isset($module[0]) ? $module[0] : self::getDefaultController();
        self::$action = isset($module[1]) ? $module[1] : self::getDefaultAction();
    }

    /**
     * Check request method
     * @param $method
     * @return bool
     */
    public static function isMethod($method)
    {
        return strtolower($_SERVER['REQUEST_METHOD']) == strtolower($method);
    }

    /**
     * Return request parameter value
     * @param $key
     * @param $default
     * @return mixed
     */
    public static function getParameter($key, $default = null)
    {
        return (array_key_exists($key, $_REQUEST)) ? $_REQUEST[$key] : $default;
    }

    /**
     * Return front controller (script name)
     * @return mixed
     */
    public static function getFrontController()
    {
        return self::$front_controller;
    }

    /**
     * Return request controller
     * @return mixed
     */
    public static function getController()
    {
        return self::$controller;
    }

    /**
     * Return request action
     * @return mixed
     */
    public static function getAction()
    {
        return self::$action;
    }

    /**
     * Get default bundle controller
     * @return string
     */
    private static function getDefaultController()
    {
        $ini = self::parseIniFile();
        if (!$ini || !array_key_exists(Project::getBundle(), $ini)) {
            return self::DEFAULT_URI;
        }

        $config = $ini[Project::getBundle()];
        return isset($config['controller']) ? $config['controller'] : self::DEFAULT_URI;
    }

    /**
     * Get default bundle action
     * @return string
     */
    private static function getDefaultAction()
    {
        $ini = self::parseIniFile();
        if (!$ini || !array_key_exists(Project::getBundle(), $ini)) {
            return self::DEFAULT_URI;
        }

        $config = $ini[Project::getBundle()];
        return isset($config['action']) ? $config['action'] : self::DEFAULT_URI;
    }

    /**
     * Parse Request Ini File
     * @return array|null
     */
    private static function parseIniFile()
    {
        $ini_file = ROOT_DIR . 'config/request.ini';
        return (!file_exists($ini_file)) ? null : parse_ini_file($ini_file, true);
    }
}