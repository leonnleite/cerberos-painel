<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelTemporada extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'temporada';

    /**
     * @var string
     */
    protected $_primary = 'id_temporada';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_temporada_status' => 'integer',
        'dt_inicial' => 'date',
        'dt_final' => 'date'
    );

    /**
     * @return array
     * @param string $arguments
     */
    public function active ()
    {

        $stmt = $this->_conn->prepare('select * from temporada where id_temporada_status != 2 and dt_final is null limit 1');
        $stmt->execute();

        $temporada = $stmt->fetch(\PDO::FETCH_OBJ);

        if ($temporada === false) {
            $temporada = new \stdClass();
            $temporada->id_temporada = 0;
            return $temporada;
        }

        return $temporada;
    }

}

