<?php

namespace br\com\cf\library\core\payment;

use br\com\cf\library\core\payment\PaymentAbstract,
    br\com\cf\library\core\payment\Payable

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Payment extends PaymentAbstract implements Payable
{

    /**
     * @return Payable
     */
    public static function factory ($type)
    {
        return new self($type);
    }

    /**
     * 
     */
    public function getPaymentRequest ()
    {
        return $this->_adapter->getPaymentRequest();
    }

    /**
     * 
     */
    public function getAccountCredentials ($email, $token)
    {
        return $this->_adapter->getAccountCredentials($email, $token);
    }

}