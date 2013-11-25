<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelLeilao extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'leilao';

    /**
     * @var string
     */
    protected $_primary = 'id_leilao';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_leilao_status' => 'integer',
        'id_jogador' => 'integer',
        'id_temporada' => 'integer',
        'vl_inicial' => 'integer',
        'vl_final' => 'integer',
    );

}

