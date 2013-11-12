<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract,
    br\com\app\model\ModelProduto

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelVenda extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_table = 'venda';

    /**
     * @var string
     */
    protected $_primary = 'id_venda';

    /**
     * @var string
     */
    protected $_sequence = 'venda_id_venda_seq';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_usuario' => 'integer',
        'dt_venda' => 'string',
        'vl_total' => 'float',
        'st_ativo' => 'boolean'
    );

    /**
     * @return ModelProduto
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * 
     */
    public function create ($venda)
    {

        $this->_conn->beginTransaction();

        try {

            $stmt = $this->_conn->prepare("insert into venda (id_usuario,vl_total,dt_venda) values (?,?,?)");
            $stmt->bindParam(1, $venda['id_usuario'], \PDO::PARAM_STR);
            $stmt->bindParam(2, $venda['vl_total'], \PDO::PARAM_STR);
            $stmt->bindParam(3, $this->_now, \PDO::PARAM_STR);
            $stmt->execute();

            $idVenda = $this->_conn->lastInsertId($this->_sequence);

            foreach ($venda['id_produto'] as $key => $value) {
                $stmt = $this->_conn->prepare("insert into venda_x_produto (id_venda,id_produto,qt_produto,vl_produto) values (?,?,?,?)");
                $stmt->bindParam(1, $idVenda, \PDO::PARAM_STR);
                $stmt->bindParam(2, $key, \PDO::PARAM_STR);
                $stmt->bindParam(3, $venda['qt_produto'][$key], \PDO::PARAM_STR);
                $stmt->bindParam(4, $venda['vl_produto'][$key], \PDO::PARAM_STR);
                $stmt->execute();
            }

            $this->_conn->commit();
        } catch (\PDOException $e) {
            $this->_conn->rollback();
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listVendas ()
    {
        try {
            $stmt = $this->_conn->prepare("select v.id_venda,v.dt_venda,round(v.vl_total::numeric,2) as vl_total,u.nm_usuario from venda v
                                              inner join usuario u on u.id_usuario = v.id_usuario where v.st_ativo = 1");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @return interger
     * @param integer $id
     */
    public function delete ($id)
    {
        $this->_conn->beginTransaction();
        try {
            $stmt = $this->_conn->prepare('update venda set st_ativo = 0 where id_venda = ?');
            $stmt->bindParam(1, $id, \PDO::PARAM_INT);
            $stmt->execute();
            $this->_conn->commit();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}