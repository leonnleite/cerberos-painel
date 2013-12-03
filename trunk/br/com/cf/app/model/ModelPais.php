<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelPais extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'pais';

    /**
     * @var string
     */
    protected $_primary = 'id_pais';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_pais' => 'integer',
        'nm_confederacao' => 'string',
        'cd_pais' => 'string'
    );

    /**
     * @return array
     * @param string $arguments
     */
    public function autocomplete($arguments) {

        $arguments = "%{$arguments}%";

        $stmt = $this->_conn->prepare('select id_pais as id, nm_pais as value, nm_pais as label from pais where nm_pais like ? limit 10');
        $stmt->bindParam(1, $arguments);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}

