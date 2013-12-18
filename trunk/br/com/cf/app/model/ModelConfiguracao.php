<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelConfiguracao extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'configuracao';

    /**
     * @var string
     */
    protected $_primary = 'id_configuracao';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'id_temporada' => 'integer',
        'st_painel_ativo' => 'boolean',
        'st_negociacao' => 'boolean',
        'st_compra_multa' => 'boolean',
        'st_gerenciar_salario' => 'boolean',
        'nu_premio_variacao' => 'integer',
        'nu_premio_empate' => 'integer',
        'nu_premio_gol' => 'integer',
        'nu_multa_vermelho' => 'integer',
        'nu_multa_amarelo' => 'integer',
        'nu_multa_wo' => 'integer',
        'nu_per_compra_multa' => 'integer',
        'nu_multa_recisao_contrato' => 'integer',
        'nu_dias_confirmar_resultado' => 'integer',
        'nu_perc_negociacao' => 'integer',
        'nu_relacao_passe_salario' => 'integer',
        'nu_premio_vitoria' => 'integer',
        'dt_inicio_draft' => 'date'
    );

}

