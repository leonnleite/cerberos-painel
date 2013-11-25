<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogadorProprietario extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogador_proprietario';

    /**
     * @var string
     */
    protected $_primary = 'id_jogador_proprietario';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogador' => 'integer',
        'id_usuario' => 'integer',
        'id_temporada' => 'integer'
    );

}

