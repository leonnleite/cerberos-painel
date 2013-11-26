<?php

namespace br\com\cf\library\core\payment;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
abstract class PaymentAbstract
{

    /**
     * 
     */
    public $_adapter = NULL;

    /**
     * @return void
     */
    public function __construct ($type = NULL)
    {

        $adapter = "Adapter" . ucfirst($type);
        $file = CF_APP_LIBRARY_PATH . "/core/payment/adapters/{$adapter}.php";
        $nameSpace = "br\\com\\cf\\library\\core\\payment\\adapters\\{$adapter}";

        /**
         * Lanca excessao se o adapter informado nao existir...
         */
        if (!file_exists($file)) {
            throw new \Exception("O adapter '{$type}' não existe...");
        }

        try {
            $this->_adapter = $nameSpace::factory();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}