<?php

namespace br\com\cf\library\core\message;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Message
{

    /**
     * @var array
     */
    private static $messages = NULL;

    /**
     * @return void
     */
    private function __construct ()
    {
        include(CF_APP_BASE_PATH . '/br/com/cf/constant/messages.php');
        self::$messages = $CF_APP_MESSAGE;
    }

    /**
     * @return string
     */
    public static function getMessage ($code)
    {
        if (is_null(self::$messages)) {
            new self();
        }
        if (!isset(self::$messages["{$code}"])) {
            throw new \Exception("A mensagem <strong>{$code}</strong> não foi definida na lista de mensagens!");
        }
        return self::$messages["{$code}"];
    }

}