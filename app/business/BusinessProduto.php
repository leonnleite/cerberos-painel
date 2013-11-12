<?php

namespace br\com\cf\app\business;

use br\com\cf\library\core\business\BusinessAbstract,
    br\com\cf\app\model\ModelProduto

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class BusinessProduto extends BusinessAbstract
{

    /**
     * @return BusinessProduto
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * @return \stdClass
     * @param integer $id_produto
     */
    public function findProdutoById ($id_produto)
    {
        return ModelProduto::factory()->findProdutoById($id_produto);
    }

    /**
     * @return \stdClass
     * @param array $produto
     */
    public function edit ($produto)
    {
        return ModelProduto::factory()->edit($produto);
    }

    /**
     * @return \stdClass
     * @param array $produto
     */
    public function create ($produto)
    {
        return ModelProduto::factory()->create($produto);
    }

    /**
     * @return \stdClass
     */
    public function listActiveProduto ()
    {
        return ModelProduto::factory()->listActiveProduto();
    }

    /**
     * @return void
     * @param integer $id_produto
     */
    public function delete ($id_produto)
    {
        ModelProduto::factory()->delete($id_produto);
    }

}