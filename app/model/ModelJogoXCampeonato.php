<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogoXCampeonato extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogo_x_campeonato';

    /**
     * @var string
     */
    protected $_primary = 'id_jogo_x_campeonato';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogo' => 'integer',
        'id_campeonato' => 'integer'
    );

}

