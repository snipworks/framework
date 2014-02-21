<?php

define('ROOT_DIR', dirname(dirname(__DIR__)) . '/');
Autoload::initialize();

/**
 * Class for autoloader
 * @class Autoload
 */
class Autoload
{
    /**
     * Initialize autoload class
     */
    public static function initialize()
    {
        require_once(__DIR__ . '/common.php');
        require_once(__DIR__ . '/project.php');
        require_once(__DIR__ . '/config.php');
        require_once(__DIR__ . '/request.php');
        require_once(__DIR__ . '/database.php');
        require_once(__DIR__ . '/model.php');
        require_once(__DIR__ . '/view.php');
        require_once(__DIR__ . '/controller.php');
        self::register(array('self', 'frameworkAutoload'), true, false);
    }

    /**
     * Register autoload function (Wrapper for SPL Autoload Register)
     * @param mixed $function
     * @param bool $throw
     * @param bool $prepend
     */
    public static function register($function, $throw = true, $prepend = false)
    {
        spl_autoload_register($function, $throw, $prepend);
    }

    /**
     * Default framework autoload function
     * @param $class_name
     * @throws Exception
     */
    protected static function frameworkAutoload($class_name)
    {
        $bundle = Project::getBundle();
        if (endsWith(Project::CONTROLLER, $class_name)) {
            $filename = 'apps/' . $bundle . '/controllers/' . $class_name . '.php';
        } elseif (endsWith(Project::CONFIG, $class_name)) {
            $filename = 'config/' . $class_name . '.php';
        } elseif (endsWith(Project::UTIL, $class_name)) {
            $filename = 'lib/util/' . $class_name . '.php';
        } else {
            $filename = 'lib/model/' . $class_name . '.php';
        }
        if (!file_exists(ROOT_DIR . $filename)) {
            throw new Exception('Call to undefined class "' . $class_name . '"');
        }
        require_once(ROOT_DIR . $filename);
    }
}