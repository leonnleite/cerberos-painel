<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\business\BusinessProduto

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerProduto extends ControllerAbstract
{

    /**
     * @return void
     */
    public function formCreateAction ()
    {
        $this->setView('produto', 'formCreate')->render();
    }

    /**
     * @return \stdClass
     */
    public function formEditAction ()
    {
        try {

            $produto = BusinessProduto::factory()->findProdutoById($this->getParam('id_produto'));

            $this->setView('produto', 'edit')
                    ->set('id_produto', $produto['id_produto'])
                    ->set('nm_produto', $produto['nm_produto'])
                    ->set('vl_produto', $produto['vl_produto'])
                    ->render();
        } catch (\Exception $e) {
            throw new \Exception('Ocorreu um erro ao tentar carregar as informações solicitadas!');
        }
    }

    /**
     * @return void
     */
    public function editAction ()
    {
        try {
            BusinessProduto::factory()->edit($this->getParams());
            $response = array('status' => 'success', 'message' => 'Alteração concluída com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function createAction ()
    {
        try {
            BusinessProduto::factory()->create($this->getParams());
            $response = array('status' => 'success', 'message' => 'Novo produto cadastrado com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $produtos = BusinessProduto::factory()->listActiveProduto();

        $this->setView('produto', 'list')
                ->set('produtos', $produtos)
                ->render();
    }

    /**
     * @return void
     */
    public function deleteAction ()
    {
        try {
            BusinessProduto::factory()->delete($this->getParam('id'));
            $response = array('status' => 'success', 'message' => 'Produto excluído com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar excluir o produto!');
        }

        $this->json($response);
    }

}