<?php

namespace br\com\cf\app\model;

use \PDO as PDO,
    br\com\cf\library\core\model\ModelAbstract

;

/**
 * @autor Michael F. Rodrigues
 */
class ModelPromocao extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = 'public';

    /**
     * @var string
     */
    protected $_table = 'promocao';

    /**
     * @var string
     */
    protected $_primary = 'id_promocao';

    /**
     * @var string
     */
    protected $_sequence = 'promocao_id_promocao_seq';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_promocao' => 'string',
        'pc_promocao' => 'integer',
        'dt_validade' => 'string',
        'st_ativo' => 'boolean'
    );

    /**
     * @return ModelPromocao
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * @return void
     */
    public function create ($promocao)
    {

        $this->_conn->beginTransaction();

        $dt_validade = substr($promocao['dt_validade'], 6, 4) . '-' . substr($promocao['dt_validade'], 3, 2) . '-' . substr($promocao['dt_validade'], 0, 2);

        try {

            $stmt = $this->_conn->prepare("insert into promocao (nm_promocao,pc_promocao,dt_validade) values (?,?,?)");
            $stmt->bindParam(1, $promocao['nm_promocao'], PDO::PARAM_STR);
            $stmt->bindParam(2, $promocao['pc_promocao'], PDO::PARAM_INT);
            $stmt->bindParam(3, $dt_validade, PDO::PARAM_STR);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function attachProduto ($promocao)
    {

        $this->_conn->beginTransaction();

        try {

            $stmt = $this->_conn->prepare("insert into promocao_x_produto (id_promocao,id_produto) values (?,?)");
            $stmt->bindParam(1, $promocao['id_promocao'], PDO::PARAM_STR);
            $stmt->bindParam(2, $promocao['id_produto'], PDO::PARAM_INT);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listActivePromocao ()
    {
        try {
            $stmt = $this->_conn->prepare("select * from promocao where st_ativo  = 1 and dt_validade >= CURRENT_TIMESTAMP");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listActiveProdutoInPromocao ()
    {
        try {
            $stmt = $this->_conn->prepare("select pd.id_produto,pd.nm_produto,trunc(pd.vl_produto::numeric,2) as vl_produto,pm.id_promocao,pm.nm_promocao,pm.pc_promocao,pm.dt_validade,trunc(pd.vl_produto::numeric-((pm.pc_promocao::numeric/100)*(pd.vl_produto::numeric)),2) as vl_desconto, pd.vl_produto::float/100 as vl_descontos from produto pd
                                               inner join promocao_x_produto pxp on pxp.id_produto = pd.id_produto and pxp.id_promocao not in (select id_promocao from promocao where st_ativo = 0 and dt_validade >= CURRENT_TIMESTAMP)
                                               left join promocao pm on pm.id_promocao = pxp.id_promocao and (pm.st_ativo = 1 and pm.dt_validade >= CURRENT_TIMESTAMP)
                                           where pd.st_ativo = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function delete ($id)
    {
        $this->_conn->beginTransaction();
        try {
            $stmt = $this->_conn->prepare("update promocao set st_ativo = 0 where id_promocao = ? limit 1");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->_conn->commit();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function unAttachProduto ($idProduto, $idPromocao)
    {
        $this->_conn->beginTransaction();
        try {
            $stmt = $this->_conn->prepare("delete from promocao_x_produto where id_produto = ? and id_promocao = ? limit 1");
            $stmt->bindParam(1, $idProduto, PDO::PARAM_INT);
            $stmt->bindParam(2, $idPromocao, PDO::PARAM_INT);
            $stmt->execute();
            $this->_conn->commit();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}