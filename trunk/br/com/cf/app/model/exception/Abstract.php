<?php

class Exception_Model_Abstract extends Exception
{

    protected $_generic = 'Ocorreu um erro ao tentar concluir a solicitação!';
    protected $_uniques = array(
        'un_tx_email' => 'Email',
        'un_nu_cpf' => 'CPF',
        'un_nm_produto' => 'Produto',
    );

    public function __construct (PDOException $e)
    {
        switch ($e->getCode()) {

            case '23000':
                $filter = $this->_unique($e->getMessage());
                break;
        }

        $this->message = !is_null($filter) ? $filter : $this->_generic;
    }

    public function getError ()
    {
        return $this->_error;
    }

    private function _unique ($message)
    {
        $array = explode('|', str_replace(
                        array("SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '", "' for key '", "'"), array('', '|', ''), $message)
        );
        return "O {$this->_uniques[$array[1]]} <strong>{$array[0]}</strong> já está cadastrado!";
    }

}