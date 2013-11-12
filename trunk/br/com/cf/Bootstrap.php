<?php

namespace br\com\cf;

use br\com\cf\library\core\bootstrap\BootstrapAbstract,
    br\com\cf\library\core\exception\ExceptionAcl,
    br\com\cf\library\core\acl\Acl

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Bootstrap extends BootstrapAbstract
{

    /**
     * @var Bootstrap
     */
    private static $instance;

    /**
     * @return Bootstrap
     */
    protected static function singleton ()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Bootstrap
     */
    public static function factory ()
    {
        return self::singleton();
    }

    /**
     * @return void
     */
    protected function _initialize ()
    {
        try {
            /**
             * Verificar se o usuario logado possui acesso ao controller e action informados...
             */
//            Acl::factory()->isGranted($this);
        } catch (ExceptionAcl $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array;
     */
    public function getPDOExtraParams ()
    {
        return array(
//            \PDO::ATTR_PERSISTENT => true,
//            \PDO::ATTR_CASE => \PDO::CASE_LOWER,
//            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );
    }

}