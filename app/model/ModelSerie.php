<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelSerie extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'serie';

    /**
     * @var string
     */
    protected $_primary = 'id_serie';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_serie' => 'string',
    );

    /**
     * @return array
     */
    public function retrieveActiveSeries ()
    {
        $stmt = $this->_conn->prepare('select s.id_serie, s.nm_serie from usuario u 
                                            inner join serie s ON s.id_serie = u.id_serie
                                       group by u.id_serie order by s.id_serie asc');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * @return array
     */
    public function retrieveLastActiveSeries ()
    {
        $stmt = $this->_conn->prepare('select s.id_serie, s.nm_serie from usuario u 
                                            inner join serie s ON s.id_serie = u.id_serie
                                       group by u.id_serie order by s.id_serie desc limit 1');
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ);
    }

}

