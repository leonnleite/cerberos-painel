<?php

namespace br\com\cf\library\core\view;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
abstract class ViewAbstract
{

    /**
     * @var Vieweable
     */
    public $_adapter = NULL;

    /**
     * @return void
     */
    public function __construct ($controller, $view, $type = NULL)
    {

        if (is_null($type)) {
            $type = CF_APP_VIEW_TYPE_DEFAULT;
        }

        $adapter = "Adapter" . ucfirst($type);
        $file = CF_APP_LIBRARY_PATH . "/core/view/adapters/{$adapter}.php";
        $nameSpace = "br\\com\\cf\\library\\core\\view\\adapters\\{$adapter}";

        /**
         * Lanca excessao se o adapter informado nao existir...
         */
        if (!file_exists($file)) {
            throw new \Exception("O adapter '{$type}' não existe...");
        }

        try {
            $this->_adapter = $nameSpace::factory($controller, $view);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}