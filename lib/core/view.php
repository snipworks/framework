<?php

/**
 * Class View
 */
class View
{
    const TEMPLATE = 'TEMPLATE';
    const NONE = 'NONE';

    private $data;
    private $template;
    private $view_file;

    /**
     * View constructor
     */
    public function __construct()
    {
        $this->setTemplate(Request::getAction());
    }

    /**
     * Set variable and value for view
     * @param $var
     * @param $val
     */
    public function set($var, $val)
    {
        $this->data[$var] = $val;
    }

    /**
     * Set/change view file template
     * @param $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * Display view
     * @throws Exception
     */
    public function render()
    {
        $contents = $this->getOutput();
        $layout = ROOT_DIR . 'apps/' . Project::getBundle() . '/templates/layout.php';
        if (!file_exists($layout)) {
            throw new Exception('File ' . $layout . ' not found.');
        }
        require_once($layout);
    }

    /**
     * Retrieve view file output (HTML)
     * @return string
     */
    private function getOutput()
    {
        $this->validateView();
        extract(($this->data + $this->getDefinedVars()), EXTR_SKIP);

        ob_start();
        ob_implicit_flush(0);
        require_once($this->view_file);
        $output = ob_get_contents();
        ob_end_clean();
        return $output . PHP_EOL;
    }

    /**
     * Validate view filename and data from controller
     * @throws Exception
     */
    private function validateView()
    {
        $filename = ROOT_DIR . 'apps/' . Project::getBundle() .
            '/views/' . Request::getController() . '/' . $this->template . '.php';

        if (!file_exists($filename)) {
            throw new Exception('File ' . $filename . ' not found.');
        }
        $this->data = (!$this->data) ? array() : $this->data;
        $this->view_file = $filename;
    }

    /**
     * Get defined variables in view file
     * @return array
     */
    private function getDefinedVars()
    {
        $defined_vars = array();
        $tokens = token_get_all(file_get_contents($this->view_file));
        foreach($tokens as $token) {
            if ($token[0] == T_VARIABLE) {
                $defined_vars[ltrim($token[1], '$')] = null;
            }
        }
        return $defined_vars;
    }
}