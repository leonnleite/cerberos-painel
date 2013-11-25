<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogoResultado extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogo_resultado';

    /**
     * @var string
     */
    protected $_primary = 'id_resultado';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogo' => 'integer',
        'id_jogador' => 'integer',
        'id_status' => 'integer',
        'nu_gols' => 'integer',
        'nu_vermelho' => 'integer',
        'nu_amarelo' => 'integer',
        'dt_resultado' => 'date',
    );

}

