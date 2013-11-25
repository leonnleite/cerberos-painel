<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelLance extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'lance';

    /**
     * @var string
     */
    protected $_primary = 'id_lance';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_leilao' => 'integer',
        'id_usuario' => 'integer',
        'vl_lance' => 'integer',
        'dt_lance' => 'integer',
    );

}

