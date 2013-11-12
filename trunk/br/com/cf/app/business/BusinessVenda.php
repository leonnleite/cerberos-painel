<?php

namespace br\com\cf\app\business;

use br\com\cf\library\core\business\BusinessAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class BusinessVenda extends BusinessAbstract {

    /**
     * @return BusinessVenda
     */
    public static function factory() {
        return new self();
    }

}