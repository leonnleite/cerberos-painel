<?php

namespace br\com\cf\library\core\view\adapters;

use br\com\cf\library\core\view\Vieweable;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class AdapterPhtml implements Vieweable
{

    private $_phtml;

    /**
     * @return void
     */
    private function __construct ($controller, $view)
    {
        $this->_phtml = CF_APP_VIEW_PATH . "/{$controller}/{$view}.phtml";

        /**
         * Lanca excessao se a view nao existir...
         */
        if (!file_exists($this->_phtml)) {
            throw new \Exception("A View '{$this->_phtml}' não existe...");
        }
    }

    /**
     * @return AdapterPhtml
     */
    public static function factory ($controller, $view)
    {
        return new self($controller, $view);
    }

    /**
     * @return AdapterPhtml
     */
    public function set ($name, $value, $nocache = true)
    {
        $this->$name = $value;
        return $this;
    }

    /**
     * @return void
     */
    public function render ()
    {
        include($this->_phtml);
    }

}