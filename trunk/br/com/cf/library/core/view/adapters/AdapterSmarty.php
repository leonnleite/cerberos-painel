<?php

namespace br\com\cf\library\core\view\adapters;

use br\com\cf\library\core\view\Vieweable;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class AdapterSmarty implements Vieweable
{

    /**
     * 
     */
    protected $_smarty;

    /**
     * 
     */
    private $_tpl;

    /**
     * @return void
     */
    private function __construct ($controller, $view)
    {
        $this->_tpl = CF_APP_VIEW_PATH . "/{$controller}/{$view}.tpl";

        /**
         * Lanca excessao se o template nao existir...
         */
        if (!file_exists($this->_tpl)) {
            throw new \Exception("O template '{$this->_tpl}' não existe...");
        }

        /**
         * Include necessarios para o correto funcionamento do Smarty...
         */
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/sysplugins/smarty_internal_templatecompilerbase.php');
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/sysplugins/smarty_internal_compilebase.php');
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/sysplugins/smarty_internal_templatelexer.php');
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/sysplugins/smarty_internal_templateparser.php');
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/sysplugins/smarty_internal_write_file.php');
        include(CF_APP_LIBRARY_PATH . '/smarty/libs/Smarty.class.php');

        /**
         * Configuracao do Smarty
         */
        $this->_smarty = new \Smarty;

        $this->_smarty->force_compile = true;
        $this->_smarty->debugging = false;
        $this->_smarty->caching = true;
        $this->_smarty->cache_lifetime = 120;
        $this->_smarty->cache_dir = CF_APP_CACHE_PATH;

        $this->_smarty->setCacheDir(CF_APP_CACHE_PATH);
        $this->_smarty->setCompileDir(CF_APP_CACHE_PATH);
    }

    /**
     * @return AdapterSmarty
     */
    public static function factory ($controller, $view)
    {
        return new self($controller, $view);
    }

    /**
     * @return AdapterSmarty
     */
    public function set ($var, $value, $nocache = true)
    {
        $this->_smarty->assign($var, $value, $nocache);
        return $this;
    }

    /**
     * @return void
     */
    public function render ()
    {
        $this->_smarty->display($this->_tpl);
    }

}