<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelSelecao extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'selecao';

    /**
     * @var string
     */
    protected $_primary = 'sq_selecao';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'sq_selecao' => 'integer',
        'sq_pais' => 'integer',
        'nm_selecao' => 'string'
    );

}

