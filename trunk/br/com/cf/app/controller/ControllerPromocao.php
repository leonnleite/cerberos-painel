<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\model\ModelPromocao,
    br\com\cf\app\model\ModelProduto

;

/**
 * @autor Michael F. Rodrigues
 */
class ControllerPromocao extends ControllerAbstract
{

    /**
     * @return void
     */
    public function formCreateAction ()
    {
        $this->setView('promocao', 'formCreate')->render();
    }

    /**
     * @return void
     */
    public function formAttachProdutoAction ()
    {
        $produtos = ModelProduto::factory()->listActiveProdutoNotInPromocao();

        $promocoes = ModelPromocao::factory()->listActivePromocao();

        $this->setView('promocao', 'formAttachProduto')
                ->set('promocoes', $promocoes)
                ->set('produtos', $produtos)
                ->render();
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $promocoes = ModelPromocao::factory()->listActivePromocao();

        $this->setView('promocao', 'list')
                ->set('promocoes', $promocoes)
                ->render();
    }

    /**
     * @return void
     */
    public function listUnAttachProdutoAction ()
    {
        $produtos = ModelPromocao::factory()->listActiveProdutoInPromocao();

        $this->setView('promocao', 'listUnAttach')
                ->set('produtos', $produtos)
                ->render();
    }

    /**
     * @return void
     */
    public function createAction ()
    {
        try {
            ModelPromocao::factory()->create($this->getParams());
            $response = array('status' => 'success', 'message' => 'Nova promoção cadastrada com sucesso!');
        } catch (Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar salvar a nova promoção!');
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function attachProdutoAction ()
    {
        try {
            ModelPromocao::factory()->attachProduto($this->getParams());
            $response = array('status' => 'success', 'message' => 'Produto e Promoção vinculados com sucesso!');
        } catch (Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar vincular o produto à promoção!');
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function deleteAction ()
    {
        try {
            ModelPromocao::factory()->delete($this->getParam('id'));
            $response = array('status' => 'success', 'message' => 'Promoção excluída com sucesso!');
        } catch (Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar excluir a promoção!');
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function unAttachProdutoAction ()
    {
        try {
            ModelPromocao::factory()->unAttachProduto($this->getParam('idProduto'), $this->getParam('idPromocao'));
            $response = array('status' => 'success', 'message' => 'Produto desvinculado com sucesso!');
        } catch (Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar desvincular o produto!' . $e->getMessage());
        }

        $this->json($response);
    }

}