<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelTransacao extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'transacao';

    /**
     * @var string
     */
    protected $_primary = 'id_transacao';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_transacao_tipo' => 'integer',
        'id_usuario' => 'integer',
        'dt_transacao' => 'date',
        'vl_transacao' => 'integer',
        'ds_transacao' => 'string',
    );

}

