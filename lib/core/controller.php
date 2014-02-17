<?php

/**
 * Class Controller
 */
abstract class Controller
{
    private $view;

    /**
     * class constructor
     */
    final public function __construct()
    {
        $this->view = new View();
    }

    /**
     * Validate call function
     * @param $name
     * @param $args
     * @return mixed
     * @throws Exception
     */
    final public function __call($name, $args)
    {
        if (!method_exists($this, $name)) {
            throw new Exception('Call to undefined method ' . get_class($this) . '::' . $name);
        }
        return call_user_func(array($this, $name), $args);
    }

    /**
     * Set all variable and values to view
     * @param $var
     * @param $value
     */
    final public function __set($var, $value)
    {
        $this->view->set($var, $value);
    }

    /**
     * Modify view template file
     * @param $template
     */
    final public function setTemplate($template)
    {
        $this->view->setTemplate($template);
    }

    /**
     * Do controller's action name
     * @param $action
     */
    final public function execute($action)
    {
        $action .= 'Action';
        $this->preAction();
        $display = $this->{$action}();
        $this->postAction();
        if ($display !== View::NONE) {
            $this->view->render();
        }
    }

    /**
     * Function before execute action
     */
    public function preAction()
    {

    }

    /**
     * Function after execute action
     */
    public function postAction()
    {

    }

    /**
     * Redirect to new page
     * @param $url
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}