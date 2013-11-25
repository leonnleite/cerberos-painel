<?php

namespace br\com\cf\app\model;

use br\com\cf\library\core\model\ModelAbstract;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelJogador extends ModelAbstract {

    /**
     * @var string
     */
    protected $_schema = '';

    /**
     * @var string
     */
    protected $_table = 'jogador';

    /**
     * @var string
     */
    protected $_primary = 'id_jogador';

    /**
     * @var string
     */
    protected $_sequence = '';

    /**
     * @var array
     */
    protected $_fields = array(
        'nm_abreviado' => 'string',
        'nm_completo' => 'string',
        'dt_nascimento' => 'date',
        'nu_altura' => 'integer',
        'nu_peso' => 'integer',
        'tx_pe_preferido' => 'string',
        'sq_pais' => 'integer',
        'nu_overall' => 'integer',
        'cd_po_preferida_1' => 'string',
        'cd_po_preferida_2' => 'string',
        'cd_po_preferida_3' => 'string',
        'nu_aceleracao' => 'integer',
        'nu_velocidade_final' => 'integer',
        'nu_agilidade' => 'integer',
        'nu_equilibrio' => 'integer',
        'nu_pulo' => 'integer',
        'nu_resistencia' => 'integer',
        'nu_forca' => 'integer',
        'nu_reacao' => 'integer',
        'nu_agressao' => 'integer',
        'nu_intercepcao' => 'integer',
        'nu_posicionamento' => 'integer',
        'nu_visao_jogo' => 'integer',
        'nu_controle_bola' => 'integer',
        'nu_cruzamento' => 'integer',
        'nu_drible' => 'integer',
        'nu_finalizacao' => 'integer',
        'nu_cobranca_falta' => 'integer',
        'nu_cabeceio' => 'integer',
        'nu_passe_longo' => 'integer',
        'nu_passe_curto' => 'integer',
        'nu_marcacao' => 'integer',
        'nu_forca_chute' => 'integer',
        'nu_chute_longe' => 'integer',
        'nu_roubada_bola' => 'integer',
        'nu_carrinho' => 'integer',
        'nu_voleios' => 'integer',
        'nu_curva' => 'integer',
        'nu_penaltis' => 'integer',
        'nu_salto' => 'integer',
        'nu_habilidade_mao' => 'integer',
        'nu_habilidade_pe' => 'integer',
        'nu_reflexo' => 'integer',
        'nu_posicionamento_goleiro' => 'integer',
        'nu_potencial' => 'integer',
        'nu_reputacao_internacional' => 'integer',
        'nu_pe_ruim' => 'integer',
        'nu_dribles_habilidade' => 'integer',
        'tx_ataque' => 'string',
        'tx_defesa' => 'integer',
        'sq_clube' => 'integer',
        'sq_selecao' => 'integer',
        'id_sofifa' => 'integer'
    );

}

