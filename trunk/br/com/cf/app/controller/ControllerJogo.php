<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerJogo extends ControllerAbstract
{

    /**
     * @return void
     */
    public function indexAction ()
    {
        
    }

    /**
     * @return void
     */
    public function formComentariosAction ()
    {

        $comentarios = \br\com\cf\app\model\ModelJogoComentario::factory()->retrieveComentariosByIdJogo($this->getParam('id_jogo'));
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
    public function createComentarioAction ()
    {
        try {

            \br\com\cf\app\model\ModelJogoComentario::factory()->insert($this->getParams());

            $response = array('status' => 'success', 'message' => 'Comentário registrado com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function createRegistrarResultadoPartidaAction ()
    {

        //@todo se jah existir um jogo registrado entao atualizar, senao, criar

        try {

            $resultado = $this->getParam('resultado');

            \br\com\cf\app\model\ModelJogoResultado::factory()->beginTransaction();

            foreach ($resultado['nu_gols'] as $id_jogador => $gols) {
                \br\com\cf\app\model\ModelJogoResultado::factory()->insert(array(
                    'id_jogo' => $this->getParam('id_jogo'),
                    'id_jogador' => $id_jogador,
                    'id_status' => 1,
                    'nu_gols' => $gols,
                    'nu_vermelho' => $resultado['nu_vermelhos'],
                    'nu_amarelo' => $resultado['nu_amarelos'],
                    'dt_resultado' => date('Y-m-d'),
                ));
            }

            \br\com\cf\app\model\ModelJogoResultado::factory()->commit();

            $response = array('status' => 'success', 'message' => 'Resultado registrado com sucesso!');
        } catch (\Exception $e) {
            \br\com\cf\app\model\ModelJogoResultado::factory()->rollback();
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function formRegistrarResultadoAction ()
    {
        $jogadores = \br\com\cf\app\model\ModelJogadorProprietario::factory()->retrieveJogadoresByIdUsuario(
                \br\com\cf\library\core\session\Session::get('user')->id_usuario, \br\com\cf\app\model\ModelTemporada::factory()->active()->id_temporada
        );

        $jogo = \br\com\cf\app\model\ModelJogo::factory()->find($this->getParam('id_jogo'));

        $this->setView('jogo', 'formRegistrarResultado')
                ->set('usuario', \br\com\cf\library\core\session\Session::get('user'))
                ->set('jogadores', $jogadores)
                ->set('jogo', $jogo)
                ->render();
    }

}