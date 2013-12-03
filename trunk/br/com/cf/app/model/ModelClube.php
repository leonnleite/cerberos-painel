<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelClube extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'clube';

    /**
     * @var string
     */
    protected $_primary = 'id_clube';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_clube' => 'integer',
        'id_pais' => 'integer',
        'nm_clube' => 'string'
    );

    /**
     * @return array
     * @param string $arguments
     */
    public function autocomplete($arguments) {

        $arguments = "%{$arguments}%";

        $stmt = $this->_conn->prepare('select id_clube as id, nm_clube as value, nm_clube as label from clube where nm_clube like ? limit 10');
        $stmt->bindParam(1, $arguments);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

