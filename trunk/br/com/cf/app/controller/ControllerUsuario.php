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

            $this->setView('usuario', 'edit')
                    ->set('id_usuario', $usuario['id_usuario'])
                    ->set('nm_usuario', $usuario['nm_usuario'])
                    ->set('nu_cpf', $usuario['nu_cpf'])
                    ->set('fg_perfil', $usuario['fg_perfil'])
                    ->set('tx_email', $usuario['tx_email'])
                    ->render();
        } catch (\Exception $e) {
            print('Ocorreu um erro ao tentar carregar as informações solicitadas!');
        }
    }

    /**
     * 
     */
    public function formCreateAction() {
        $this->setView('usuario', 'formCreate')->render();
    }

    /**
     * @return void
     */
    public function editAction() {
        try {
            BusinessUsuario::factory()->edit($this->getParams());
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

        $usuarios = BusinessUsuario::factory()->listActiveUsuario();

        $this->setView('usuario', 'list')
                ->set('usuarios', $usuarios)
                ->render();
    }

    /**
     * @return void
     */
    public function listClienteAction() {

        $usuarios = BusinessUsuario::factory()->listActiveCliente();

        $this->setView('usuario', 'listCliente')
                ->set('usuarios', $usuarios)
                ->render();
    }

    /**
     * @return void
     */
    public function listAdministradorAction() {

        $usuarios = BusinessUsuario::factory()->listActiveAdministrador();

        $this->setView('usuario', 'listAdministrador')
                ->set('usuarios', $usuarios)
                ->render();
    }

    /**
     * @return void
     */
    public function deleteAction() {
        try {
            BusinessUsuario::factory()->delete($this->getParam('id'));
            $response = array('status' => 'success', 'message' => 'Usuário excluído com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar excluir o usuário!');
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function findClienteByCpfAction() {
        try {

            $usuario = BusinessUsuario::factory()->findClienteByCpf(preg_replace("/[^0-9]/", "", $this->getParam('nu_cpf')));

            if (is_array($usuario)) {
                $response = array('status' => 'success', 'id_usuario' => $usuario['id_usuario'], 'nm_usuario' => $usuario['nm_usuario']);
            } else {
                $response = array('status' => 'error', 'message' => 'Não foi encontrado um cliente com o cpf informado!');
            }
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => 'Ocorreu um erro ao tentar verificar o CPF do Cliente!');
        }

        $this->json($response);
    }

}