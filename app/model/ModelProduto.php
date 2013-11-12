<?php

namespace br\com\cf\app\model;

use \PDO as PDO,
    br\com\cf\library\core\model\ModelAbstract

;

class ModelProduto extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = 'public';

    /**
     * @var string
     */
    protected $_table = 'produto';

    /**
     * @var string
     */
    protected $_primary = 'id_produto';

    /**
     * @var string
     */
    protected $_sequence = 'produto_id_produto_seq';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_produto' => 'string',
        'vl_produto' => 'float',
        'st_ativo' => 'boolean'
    );

    /**
     * @return void
     */
    public function create ($produto)
    {

        $this->_conn->beginTransaction();

        try {

            $stmt = $this->_conn->prepare("insert into produto (nm_produto,vl_produto) values (?,?)");
            $stmt->bindParam(1, $produto['nm_produto'], PDO::PARAM_STR);
            $stmt->bindParam(2, $produto['vl_produto'], PDO::PARAM_STR);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception_Produto($e);
        }
    }

    /**
     * @return void
     */
    public function edit ($produto)
    {

        $this->_conn->beginTransaction();

        try {

            $stmt = $this->_conn->prepare("update produto set nm_produto = ?, vl_produto = ? where id_produto = ? limit 1");
            $stmt->bindParam(1, $produto['nm_produto'], PDO::PARAM_STR);
            $stmt->bindParam(2, $produto['vl_produto'], PDO::PARAM_STR);
            $stmt->bindParam(3, $produto['id_produto'], PDO::PARAM_STR);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception_Produto($e);
        }
    }

    /**
     * 
     */
    public function listActiveProduto ()
    {
        try {
            $stmt = $this->_conn->prepare("select pd.id_produto,pd.nm_produto,trunc(pd.vl_produto::numeric,2) as vl_produto,pm.id_promocao,pm.nm_promocao,pm.pc_promocao,pm.dt_validade,trunc(pd.vl_produto::numeric-((pm.pc_promocao::numeric/100)*(pd.vl_produto::numeric)),2) as vl_desconto from produto pd
                                               left join promocao_x_produto pxp on pxp.id_produto = pd.id_produto and pxp.id_promocao not in (select id_promocao from promocao where st_ativo = 0 and dt_validade >= CURRENT_TIMESTAMP)
                                               left join promocao pm on pm.id_promocao = pxp.id_promocao and (pm.st_ativo = 1 and pm.dt_validade >= CURRENT_TIMESTAMP)
                                           where pd.st_ativo = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listActiveProdutoNotInPromocao ()
    {
        try {
            $stmt = $this->_conn->prepare("select * from produto where st_ativo = 1 and id_produto not in (
                                           select pxp.id_produto from promocao_x_produto pxp
                                               inner join promocao pm on pm.id_promocao = pxp.id_promocao
                                               inner join produto pd on pd.id_produto = pxp.id_produto
                                           where pd.st_ativo = 1 and pm.st_ativo = 1 and pm.dt_validade >= CURRENT_TIMESTAMP)");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function findProdutoById ($id)
    {
        try {
            $stmt = $this->_conn->prepare("select id_produto,nm_produto,trunc(vl_produto::numeric,2) as vl_produto from produto where st_ativo = 1 and id_produto = ? limit 1");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}