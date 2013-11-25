<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogoComentario extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogo_comentario';

    /**
     * @var string
     */
    protected $_primary = 'id_comentario';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogo' => 'integer',
        'id_usuario' => 'integer',
        'tx_comentario' => 'string',
        'dt_comentario' => 'date',
    );

}

