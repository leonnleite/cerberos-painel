<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogoComentario extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogo_comentario';

    /**
     * @var string
     */
    protected $_primary = 'id_comentario';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_jogo' => 'integer',
        'id_usuario' => 'integer',
        'tx_comentario' => 'string',
        'dt_comentario' => 'date',
    );

    /**
     * @return array
     * @param integer $idJogo
     */
    public function retrieveComentariosByIdJogo ($idJogo)
    {

        $stmt = $this->_conn->prepare('select c.id_comentario, c.id_jogo, c.id_usuario, u.nm_usuario, u.nm_equipe, c.tx_comentario, u.lg_live, c.dt_comentario from jogo_comentario c
                                            inner join jogo j on j.id_jogo = c.id_jogo
                                            inner join usuario u on u.id_usuario = c.id_usuario
                                       where c.id_jogo = ?');
        $stmt->bindParam(1, $idJogo, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

}

