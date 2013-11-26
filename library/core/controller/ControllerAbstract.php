<?php

namespace br\com\cf\library\core\controller;

use br\com\cf\library\core\view\View;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
abstract class ControllerAbstract
{

    /**
     * @var \br\com\cf\library\core\view\Vieweable
     */
    protected $_view = NULL;

    /**
     * @return string
     * @param string $param
     */
    public function getParam ($param)
    {
        return $_REQUEST[$param];
    }

    /**
     * @return boolean
     * @param string $param
     */
    public function getParamExist ($param)
    {
        return isset($_REQUEST["{$param}"]);
    }

    /**
     * @return array
     */
    public function getParams ()
    {
        return $_REQUEST;
    }

    /**
     * @return array
     * @param string $param
     */
    public function getRequestFile ($param)
    {
        return $_FILES[$param];
    }

    /**
     * @return array
     */
    public function getRequestFiles ()
    {
        return $_FILES;
    }

    /**
     * @return void
     * @param string $class
     * @param string $method
     */
    public function forward ($class, $method)
    {
        $action = "{$method}Action";

        $nameSpace = "br\com\cf\app\controller\\Controller{$class}";

        $controller = new $nameSpace();
        $controller->$action();

        exit();
    }

    /**
     * @return \br\com\cf\library\core\view\Vieweable
     * @param string $controller
     * @param string $view
     * @param string $type
     */
    public function setView ($controller, $view, $type = NULL)
    {
        try {
            return $this->_view = View::factory($controller, $view, $type);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function indexAction ()
    {
        
    }

    /**
     * @return void
     */
    public function before ()
    {
        
    }

    /**
     * @return void
     */
    public function after ()
    {
        
    }

    /**
     * @return void
     * @param mixed $response
     */
    public function json ($response)
    {
        echo (json_encode($response));
    }

    /**
     * @return void
     * @param string $name
     * @param mixed $arguments
     */
    public function __call ($name, $arguments)
    {
        throw new \Exception(sprintf('A action "<strong>%s</strong>" não foi definida!', substr($name, -0, -6)));
    }

    /**
     * @return void
     * @param string $url
     */
    protected function _redirect ($url)
    {
        header("Location: $url");
    }

}