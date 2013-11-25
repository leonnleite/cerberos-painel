<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelCopa extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'copa';

    /**
     * @var string
     */
    protected $_primary = 'id_copa';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_temporada' => 'integer',
        'nm_copa' => 'string'
    );

}

