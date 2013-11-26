<?php

namespace br\com\cf\library\core\session;

/**
 * Classe responsavel por manipular sessao...
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Session
{

    /**
     * Inicia a sessao...
     * @return void
     */
    public static function start ($name)
    {
        session_start($name);
    }

    /**
     * Setar um campo da sessao com um valor ou objeto informado...
     * @return void
     */
    public static function set ($name, $value = null)
    {
        $_SESSION['cf']["{$name}"] = serialize($value);
    }

    /**
     * Recuperar um valor ou objeto da sessao a partir do campo informado...
     * @return mixed
     */
    public static function get ($name)
    {
        if (isset($_SESSION['cf'][$name])) {
            return unserialize($_SESSION['cf'][$name]);
        } else {
            throw new \Exception("Este atributo não está na sessão! <strong>{$name}</strong>");
        }
    }

    /**
     * Destroy um campo da sessao ou sessao completa...
     * @return void
     */
    public static function destroy ($name = false)
    {
        if ($name) {
            unset($_SESSION['cf'][$name]);
        } else {
            unset($_SESSION['cf']);
        }
    }

    /**
     * Verifica se um determinado campos este setado...
     * @return boolean
     */
    public static function exists ($name)
    {
        return isset($_SESSION['cf'][$name]);
    }

}