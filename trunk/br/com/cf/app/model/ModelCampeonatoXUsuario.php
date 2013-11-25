<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelCampeonatoXUsuario extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'campeonato_x_usuario';

    /**
     * @var string
     */
    protected $_primary = 'id_campeonato_x_usuario';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_campeonato' => 'integer',
        'id_usuario' => 'integer',
    );

}

