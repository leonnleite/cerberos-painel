<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelSelecao extends ModelAbstract {

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
    protected $_primary = 'id_selecao';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_pais' => 'integer',
        'nm_selecao' => 'string'
    );

    /**
     * @return array
     * @param string $arguments
     */
    public function autocomplete($arguments) {

        $arguments = "%{$arguments}%";

        $stmt = $this->_conn->prepare('select id_selecao as id, nm_selecao as value, nm_selecao as label from selecao where nm_selecao like ? limit 10');
        $stmt->bindParam(1, $arguments);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

