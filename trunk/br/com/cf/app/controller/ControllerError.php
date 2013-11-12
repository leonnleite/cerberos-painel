<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerError extends ControllerAbstract
{

    /**
     * @return ControllerError
     */
    public static function factory ()
    {
        return new self();
    }

}