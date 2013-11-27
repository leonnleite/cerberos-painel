<?php

namespace br\com\cf\app\business;

use br\com\cf\library\core\business\BusinessAbstract,
    br\com\cf\app\model\ModelUsuario

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class BusinessUsuario extends BusinessAbstract {

    /**
     * @return BusinessUsuario
     */
    public static function factory() {
        return new self();
    }

    /**
     * @return \stdClass
     * @param integer $id_usuario
     */
    public function findUsuarioById($id_usuario) {
        return ModelUsuario::factory()->findUsuarioById($id_usuario);
    }

    /**
     * @return void
     * @param array $usuario
     */
    public function edit($usuario) {
        $usuario['nu_cpf'] = preg_replace("/[^0-9]/", "", $usuario['nu_cpf']);
        try {
            return ModelUsuario::factory()->update($usuario);
        } catch (\Exception $e) {
            throw new \Exception('Ocorreu um erro ao tentar alterar o usuário!' . $e->getMessage());
        }
    }

    /**
     * @return void
     * @param array $usuario
     */
    public function save($usuario) {
        try {
            return ModelUsuario::factory()->insert($usuario);
        } catch (\Exception $e) {
            throw new \Exception('Ocorreu um erro ao tentar criar o novo usuário!');
        }
    }

    /**
     * @return \stdClass[]
     */
    public function listActiveUsuario() {
        try {
            return ModelUsuario::factory()->listActiveUsuario();
        } catch (\Exception $e) {
            throw new \Exception('Ocorreu um erro ao tentar listar os usuários ativos!');
        }
    }

    /**
     * @return \stdClass[]
     */
    public function listActiveCliente() {
        return ModelUsuario::factory()->listActiveCliente();
    }

    /**
     * @return \stdClass[]
     */
    public function listActiveAdministrador() {
        return ModelUsuario::factory()->listActiveAdministrador();
    }

    /**
     * @return void
     * @param integer $id_usuario
     */
    public function delete($id_usuario) {
        ModelUsuario::factory()->delete($id_usuario);
    }

    /**
     * @return \stdClass
     * @param string $nu_cpf
     */
    public function findClienteByCpf($nu_cpf) {
        return ModelUsuario::factory()->findClienteByCpf($nu_cpf);
    }

}