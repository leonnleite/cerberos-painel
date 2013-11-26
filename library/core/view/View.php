<?php

namespace br\com\cf\library\core\view;

use br\com\cf\library\core\view\ViewAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class View extends ViewAbstract implements Vieweable
{

    /**
     * @return View
     */
    public static function factory ($controller, $view, $type = NULL)
    {
        return new self($controller, $view, $type);
    }

    /**
     * @return View
     */
    public function set ($var, $value, $nocache = true)
    {
        $this->_adapter->set($var, $value, $nocache);
        return $this->_adapter;
    }

    /**
     * @return void
     */
    public function render ()
    {
        $this->_adapter->render();
    }

    /**
     * @return void
     */
    public static function partials ($partial)
    {
        $file = CF_APP_PARTIALS_PATH . '/' . $partial . '.' . CF_APP_VIEW_TYPE_DEFAULT;

        if (!file_exists($file)) {
            throw new \Exception("O Partial '{$partial}' não existe...");
        }

        include ($file);
    }

}