<?php

namespace br\com\cf\library\core\acl;

use br\com\cf\library\core\session\Session,
    br\com\cf\library\core\auth\Auth,
    br\com\cf\Bootstrap

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Acl
{

    /**
     * @return void
     */
    private function __construct ()
    {
        $this->_load();
        if (Auth::isAuthenticated()) {
            if (!Acl::isActivated()) {
                $this->_load();
            }
        } else {
            if (!Acl::isActivated()) {
                $this->_load();
            }
        }
    }

    /**
     * @return Acl
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * Retorna true se existir uma Acl carregada na sessao...
     * @return boolean
     */
    public static function isActivated ()
    {
        return Session::exists('acl');
    }

    /**
     * Lanca excessao se o usuario nao possuir acesso...
     * @param Bootstrap $bootstrap
     */
    public function isGranted (Bootstrap $bootstrap)
    {

        $controller = $bootstrap->getController();
        $action = $bootstrap->getAction();

        $tasks = self::tasks();
        $allows = self::allows();


        # Se possuir permissao total de acesso interrompe a verificacao da Acl...
        if ($allows == '[ALL]') {
            return;
        }

        # Verifica se a tasks esta registrada...
        if (isset($tasks["{$controller}"]["{$action}"])) {
            $task = $tasks["{$controller}"]["{$action}"];
        } else {
            throw new \Exception("A task <strong>{$controller}/{$action}</strong> não foi registrada!");
        }

        # Verifica se o usuario possui permissao de acesso a tasks...
        if (strpos($allows, "[{$task}]") <= -1) {

            $cfg = Bootstrap::factory()->getConfig();
            $fieldProfile = ($cfg->getParam('acl.fieldProfile')) ? $cfg->getParam('acl.fieldProfile') : 'cd_profile';
            $userProfile = Auth::isAuthenticated() ? Session::get('user')->{$fieldProfile} : 0;

            throw new \Exception("Acesso Negado à task <strong>{$controller}/{$action} ({$userProfile})</strong>!");
        }
    }

    /**
     * @return void
     */
    private function _load ()
    {
        try {

            $tasks = array();
            $allows = '';

            $cfg = Bootstrap::factory()->getConfig();

            $fieldProfile = ($cfg->getParam('acl.fieldProfile')) ? (string) $cfg->getParam('acl.fieldProfile') : 'cd_profile';
            $userProfile = Auth::isAuthenticated() ? Session::get('user')->{$fieldProfile} : 0;

            $aclTasks = $cfg->getParam('acl.tasks');
            $aclProfiles = $cfg->getParam('acl.profiles');

            foreach ($aclProfiles as $key => $object) {
                if ($key == $userProfile) {
                    $object = explode('|', $object);
                    $allows = $object[1];
                    break;
                }
            }

            foreach ($aclTasks as $key => $object) {
                $object = explode('|', $object);
                $tasks[$object[0]][$object[1]] = $key;
            }

            Session::set('acl', array('allows' => (string) $allows, 'tasks' => (array) $tasks));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Retorna uma string com identificador das tasks que o usuario possui permissao de acesso...
     * @return string
     */
    public static function allows ()
    {
        $acl = Session::get('acl');
        return $acl['allows'];
    }

    /**
     * Retorna um array com a lista de tasks registradas...
     * @return array
     */
    public static function tasks ()
    {
        $acl = Session::get('acl');
        return $acl['tasks'];
    }

    /**
     * Recarrega as definicoes do Acl...
     * @return void
     */
    public function reload ()
    {
        $this->_load();
    }

}