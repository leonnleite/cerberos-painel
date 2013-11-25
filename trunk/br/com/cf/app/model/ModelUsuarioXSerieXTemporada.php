<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelUsuarioXSerieXTemporada extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'usuario_x_serie_x_temporada';

    /**
     * @var string
     */
    protected $_primary = 'id_usuario_x_serie_x_temporada';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_serie' => 'integer',
        'id_usuario' => 'integer',
        'id_temporada' => 'integer'
    );

}

