<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 * @version 0.0.0
 */
class ModelUsuario extends ModelAbstract {

    /**
     * @var string
     */
    protected $_entry = '';

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
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_usuario' => 'string',
        'tx_senha' => 'string',
        'tx_email' => 'string',
        'lg_live' => 'string',
        'fg_perfil' => 'integer',
    );

}