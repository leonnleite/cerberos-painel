<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogo extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogo';

    /**
     * @var string
     */
    protected $_primary = 'id_jogo';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_status' => 'integer',
        'id_temporada' => 'integer',
        'id_usuario_casa' => 'integer',
        'id_usuario_visitante' => 'integer',
        'dt_jogo' => 'date',
    );

}

