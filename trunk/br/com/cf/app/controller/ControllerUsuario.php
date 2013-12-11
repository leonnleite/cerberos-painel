<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\business\BusinessUsuario,
    br\com\cf\library\core\session\Session,
    br\com\cf\library\core\auth\Auth,
    br\com\cf\Bootstrap

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerUsuario extends ControllerAbstract {

    /**
     * @return void
     */
    public function authAction() {

        Auth::factory()->autheticate(array(
            'tx_email' => $this->getParam('tx_email'),
            'tx_senha' => md5($this->getParam('tx_senha'))
        ));

        if (Auth::isAuthenticated()) {
            $response = array('status' => 'success', 'url' => Bootstrap::factory()->getConfig()->getParam('config.url'));
        } else {
            Session::destroy();
            $response = array('status' => 'error', 'message' => 'Acesso Negado!');
        }

        $this->json($response);
    }

    /**
     * return void
     */
    public function logoffAction() {
        Auth::logoff();
        header('Location: ' . Bootstrap::factory()->getConfig()->getParam('config.url'));
    }

    /**
     * @return void
     */
    public function formAuthAction() {
        $this->setView('usuario', 'formAuth')->render();
    }

    /**
     * @return void
     */
    public function formEditAction() {
        try {

            $usuario = BusinessUsuario::factory()->findUsuarioById($this->getParam('id_usuario'));

            $this->setView('usuario', 'formEdit')
                    ->set('id_usuario', $usuario->id_usuario)
                    ->set('nm_usuario', $usuario->nm_usuario)
                    ->set('tx_email', $usuario->tx_email)
                    ->set('lg_live', $usuario->lg_live)
                    ->set('fg_perfil', $usuario->fg_perfil == 1 ? 'checked' : '')
                    ->render();
        } catch (\Exception $e) {
            print('Ocorreu um erro ao tentar carregar as informações solicitadas!');
        }
    }

    /**
     * @return void
     */
    public function formCreateAction() {
        $this->setView('usuario', 'formCreate')
                ->set('series', \br\com\cf\app\model\ModelSerie::factory()->findAll())
                ->render();
    }

    /**
     * @return void
     */
    public function editAction() {
        try {

            $params = $this->getParams();

            $params['fg_perfil'] = (isset($params['fg_perfil']) && $params['fg_perfil'] === 'on') ? 1 : 0;

            BusinessUsuario::factory()->edit($params);
            $response = array('status' => 'success', 'message' => 'Alteração concluída com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function createAction() {
        try {

            $params = $this->getParams();

            $params['fg_perfil'] = (isset($params['fg_perfil']) && $params['fg_perfil'] === 'on') ? 1 : 0;
            $params['tx_senha'] = md5($params['tx_senha']);

            BusinessUsuario::factory()->save($params);

            $response = array('status' => 'success', 'message' => 'Novo usuário cadastrado com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function listAction() {
        $this->setView('usuario', 'list')->render();
    }

    /**
     * @return void
     */
    public function loadGridSearchAction() {
        $query = 'usuario u';

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_usuario')
                ->columns(array(
                    0 => array('u.id_usuario' => 'id_usuario'),
                    1 => array('u.nm_usuario' => 'nm_usuario'),
                    2 => array('u.tx_email' => 'tx_email'),
                    3 => array('u.lg_live' => 'lg_live'),
                    4 => array('u.fg_perfil' => 'fg_perfil')
                ))
                ->query($query)
                ->params($this->getParams())
                ->make()
                ->output()
        ;

        $this->json($grid);
    }

}