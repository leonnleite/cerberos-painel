<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\model\ModelVenda,
    br\com\cf\app\model\ModelProduto

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerVenda extends ControllerAbstract
{

    /**
     * @return void
     */
    public function formCreateAction ()
    {

        $produtos = ModelProduto::factory()->listActiveProduto();

        $this->setView('venda', 'formCreate')
                ->set('produtos', $produtos)
                ->render();
    }

    /**
     * @return void
     */
    public function createAction ()
    {
        try {
            ModelVenda::factory()->create($this->getParams());
            $response = array('status' => 'success', 'message' => 'Venda registrada com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar registrar a venda!' . $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $vendas = ModelVenda::factory()->listVendas();

        $this->setView('venda', 'list')
                ->set('vendas', $vendas)
                ->render();
    }

    /**
     * @return void
     */
    public function deleteAction ()
    {
        try {
            ModelVenda::factory()->delete($this->getParam('id'));
            $response = array('status' => 'success', 'message' => 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar excluir a venda!');
        }

        $this->json($response);
    }

}