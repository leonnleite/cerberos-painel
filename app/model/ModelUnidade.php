<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * 
 */
class ModelUnidade extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_table = 'TB_UNIDADES';

    /**
     * @var string
     */
    protected $_primary = 'id';

    /**
     * @var array
     */
    protected $_fields = array(
        'nome' => 'string',
        'sigla' => 'string'
    );

    /**
     * @return \stdClass
     */
    public function find ($id)
    {
        try {
            $unidade = $this->_conn->prepare("SELECT * FROM TB_UNIDADES WHERE ID = ? LIMIT 1");
            $unidade->bindParam(1, $id, \PDO::PARAM_INT);
            $unidade->execute();
            return $unidade->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return array
     */
    public function childrens ($parent)
    {
        try {
            $unidade = $this->_conn->prepare("SELECT ID, SIGLA, NOME, SUPERIOR FROM TB_UNIDADES WHERE SUPERIOR = ?");
            $unidade->bindParam(1, $parent, \PDO::PARAM_INT);
            $unidade->execute();
            return $unidade->fetchAll(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}