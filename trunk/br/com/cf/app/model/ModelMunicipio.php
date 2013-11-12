<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelMunicipio extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = 'geo';

    /**
     * @var string
     */
    protected $_table = 'municipios';

    /**
     * @var string
     */
    protected $_primary = 'sq_municipio';

    /**
     * @var string
     */
    protected $_sequence = 'geo.municipios_sq_municipio_seq';

    /**
     * @var array
     */
    protected $_fields = array(
        'sq_uf' => 'integer',
        'nm_municipio' => 'string',
        'st_ativo' => 'integer'
    );

    /**
     * 
     */
    public function textual ($tag)
    {

        $tag1 = implode('|', explode('-', str_replace(' ', '-', $tag))) . '|';
        $tag2 = implode(':*|', explode('-', str_replace(' ', '-', $tag))) . ':*';

        $tag = $tag1 . $tag2;

        $query = "select nm_municipio,ts_rank_cd(busca, to_tsquery('portuguese', ?)) as rank 
            from municipios where to_tsquery('portuguese', ?) @@ busca order by rank desc";

        try {
            $stmt = $this->_conn->prepare($query);
            $stmt->bindParam(1, $tag, \PDO::PARAM_STR);
            $stmt->bindParam(2, $tag, \PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}