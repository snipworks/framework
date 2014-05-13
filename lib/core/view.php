<?php

/**
 * Class View
 */
class View
{
    const TEMPLATE = 'TEMPLATE';
    const NONE = 'NONE';

    const EXTENSION = '.php';

    protected $data;
    protected $template;
    protected $layout = 'layout';

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
        require_once($this->getLayoutFile());
    }

    /**
     * Check and get HTML Layout file path
     * @return string
     * @throws Exception
     */
    protected function getLayoutFile()
    {
        $layout = 'apps/' . Project::getBundle() . '/templates/' . $this->layout . static::EXTENSION;
        if (!file_exists(ROOT_DIR . $layout)) {
            throw new Exception('File ' . $layout . ' not found.');
        }
        return ROOT_DIR . $layout;
    }

    /**
     * Retrieve view file output (HTML)
     * @return string
     */
    protected function getOutput()
    {
        $this->data = (!$this->data) ? array() : $this->data;
        extract(($this->data + $this->getDefinedVars()), EXTR_SKIP);

        ob_start();
        ob_implicit_flush(0);
        require_once($this->getTemplateFile());
        $output = ob_get_contents();
        ob_end_clean();
        return $output . PHP_EOL;
    }

    /**
     * Validate view filename and data from controller
     * @throws Exception
     */
    protected function getTemplateFile()
    {
        $filename = 'apps/' . Project::getBundle() .
            '/views/' . Request::getController() . '/' . $this->template . static::EXTENSION;

        if (!file_exists(ROOT_DIR . $filename)) {
            throw new Exception('File ' . $filename . ' not found.');
        }
        return ROOT_DIR . $filename;
    }

    /**
     * Get defined variables in view file
     * @return array
     */
    protected function getDefinedVars()
    {
        $defined_vars = array();
        $tokens = token_get_all(file_get_contents($this->getTemplateFile()));
        foreach($tokens as $token) {
            if ($token[0] == T_VARIABLE) {
                $defined_vars[ltrim($token[1], '$')] = null;
            }
        }
        return $defined_vars;
    }
}