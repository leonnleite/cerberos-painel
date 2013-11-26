<?php

namespace br\com\cf\library\core\auth;

use br\com\cf\library\core\session\Session,
    br\com\cf\library\core\auth\ModelAuth,
    br\com\cf\library\core\acl\Acl

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 * @version 0.0.0
 */
class Auth
{

    /**
     * @return void
     */
    private function __construct ()
    {
        
    }

    /**
     * @return Auth
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * @return Object | false
     */
    public function autheticate ($params)
    {

        $user = ModelAuth::factory()->autheticate($params);

        if (is_object($user)) {
            /**
             * Remover o Acl do convidado da sessao...
             */
            Session::destroy('acl');
            /**
             * Registra o usuario na sessao...
             */
            Session::set('user', $user);
            /**
             * Recarrega a Acl...
             */
            Acl::factory()->reload();
        }

        return $user;
    }

    /**
     * Retorna true se existir um usuario autenticado na sessao...
     * @return boolean
     */
    public static function isAuthenticated ()
    {
        return Session::exists('user');
    }

    /**
     * Retorna um object user se o mesmo estiver na sessao....
     * @return object
     */
    public static function user ()
    {
        return Session::get('user');
    }

    /**
     * Destroi a sessao ativa...
     * @return void
     */
    public static function logoff ()
    {
        Session::destroy();
    }

}