<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerJogo extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {
        
    }

    /**
     * @return void
     */
    public function formComentariosAction() {

        $comentarios = \br\com\cf\app\model\ModelJogoComentario::factory()->findByParam(array('id_jogo' => $this->getParam('id_jogo')));
        $jogo = \br\com\cf\app\model\ModelJogo::factory()->find($this->getParam('id_jogo'));

        $this->setView('jogo', 'formComentarios')
                ->set('usuario', \br\com\cf\library\core\session\Session::get('user'))
                ->set('comentarios', $comentarios)
                ->set('jogo', $jogo)
                ->render();
    }

    /**
     * @return void
     */
    public function createComentarioAction() {
        try {

            \br\com\cf\app\model\ModelJogoComentario::factory()->insert($this->getParams());

            $response = array('status' => 'success', 'message' => 'Comentário registrado com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

}