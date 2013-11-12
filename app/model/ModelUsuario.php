<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 * @version 0.0.0
 */
class ModelUsuario extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_entry = 'default';

    /**
     * @var string
     */
    protected $_table = 'usuario';

    /**
     * @var string
     */
    protected $_primary = 'id_usuario';

    /**
     * @var string
     */
    protected $_sequence = 'usuario_sq_usuario_seq';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_usuario' => 'string',
        'nu_cpf' => 'string',
        'fg_perfil' => 'integer',
        'tx_email' => 'string',
        'tx_senha' => 'string',
        'st_ativo' => 'boolean'
    );

    /**
     * 
     */
    public function autheticate ($email, $senha)
    {
        $senha = md5($senha);

        try {
            $usuario = $this->_conn->prepare("select * from usuario where st_ativo = 1 and tx_email = ? and tx_senha = ? limit 1");
            $usuario->bindParam(1, $email, PDO::PARAM_STR);
            $usuario->bindParam(2, $senha, PDO::PARAM_STR);
            $usuario->execute();
            return $usuario->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function create ($usuario)
    {

        $this->_conn->beginTransaction();

        try {

            $stmt = $this->_conn->prepare("insert into usuario (nm_usuario,nu_cpf,fg_perfil,tx_email,tx_senha) values (?,?,?,?,?)");
            $stmt->bindParam(1, $usuario['nm_usuario'], PDO::PARAM_STR);
            $stmt->bindParam(2, preg_replace("/[^0-9]/", "", $usuario['nu_cpf']), PDO::PARAM_STR);
            $stmt->bindParam(3, $usuario['fg_perfil'], PDO::PARAM_INT);
            $stmt->bindParam(4, $usuario['tx_email'], PDO::PARAM_STR);
            $stmt->bindParam(5, md5($usuario['tx_senha']), PDO::PARAM_STR);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception_Usuario($e);
        }
    }

    /**
     * @return void
     */
    public function edit ($usuario)
    {

        $this->_conn->beginTransaction();

        $cpf = preg_replace("/[^0-9]/", "", $usuario['nu_cpf']);

        try {

            $stmt = $this->_conn->prepare("update usuario set nm_usuario = ?, nu_cpf = ?, fg_perfil = ?, tx_email = ? where id_usuario = ? limit 1");
            $stmt->bindParam(1, $usuario['nm_usuario'], PDO::PARAM_STR);
            $stmt->bindParam(2, $cpf, PDO::PARAM_STR);
            $stmt->bindParam(3, $usuario['fg_perfil'], PDO::PARAM_INT);
            $stmt->bindParam(4, $usuario['tx_email'], PDO::PARAM_STR);
            $stmt->bindParam(5, $usuario['id_usuario'], PDO::PARAM_STR);
            $stmt->execute();

            $this->_conn->commit();
        } catch (PDOException $e) {
            $this->_conn->rollback();
            throw new Exception_Usuario($e);
        }
    }

    /**
     * 
     */
    public function listActiveUsuario ()
    {
        try {
            $stmt = $this->_conn->prepare("select * from usuario where st_ativo  = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function findClienteByCpf ($nu_cpf)
    {
        try {
            $stmt = $this->_conn->prepare("select * from usuario where st_ativo = 1 and fg_perfil = 0 and nu_cpf = ? limit 1");
            $stmt->bindParam(1, $nu_cpf, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function findUsuarioById ($id_usuario)
    {
        try {
            $stmt = $this->_conn->prepare("select * from usuario where st_ativo = 1 and id_usuario = ? limit 1");
            $stmt->bindParam(1, $id_usuario, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listActiveCliente ()
    {
        try {
            $stmt = $this->_conn->prepare("select * from usuario where st_ativo  = 1 and fg_perfil = 0");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function listActiveAdministrador ()
    {
        try {
            $stmt = $this->_conn->prepare("select * from usuario where st_ativo  = 1 and fg_perfil = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return void
     */
    public function delete ($id)
    {
        $this->_conn->beginTransaction();
        try {
            $stmt = $this->_conn->prepare("update usuario set st_ativo = 0 where id_usuario = ? limit 1");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            $this->_conn->commit();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * 
     */
    public function textual ()
    {
        try {
            $stmt = $this->_conn->prepare("select nm_usuario from usuario where st_ativo  = 1 and fg_perfil = 1");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

}