<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogadorProprietario extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogador_proprietario';

    /**
     * @var string
     */
    protected $_primary = 'id_jogador_proprietario';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogador' => 'integer',
        'id_usuario' => 'integer',
        'id_temporada' => 'integer'
    );

    /**
     * @return array
     * @param integer $idJogo
     */
    public function retrieveJogadoresByIdUsuario ($idUsuario, $idTemporada)
    {

        $stmt = $this->_conn->prepare('select p.id_jogador, p.id_usuario, j.nm_abreviado from jogador_proprietario p
                                            inner join usuario u on u.id_usuario = p.id_usuario
                                            inner join jogador j on j.id_jogador = p.id_jogador
                                       where p.id_usuario = ? and p.id_temporada = ? order by j.nm_completo asc');
        $stmt->bindParam(1, $idUsuario, \PDO::PARAM_INT);
        $stmt->bindParam(2, $idTemporada, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

}

