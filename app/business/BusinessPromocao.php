<?php

namespace br\com\cf\app\business;

use br\com\cf\library\core\business\BusinessAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class BusinessPromocao extends BusinessAbstract {

    /**
     * @return BusinessPromocao
     */
    public static function factory() {
        return new self();
    }

}