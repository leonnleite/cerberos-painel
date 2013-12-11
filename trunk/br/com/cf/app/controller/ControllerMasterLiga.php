<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerMasterLiga extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {
        $this->setView('masterLiga', 'index')->render();
    }

    /**
     * @return void
     */
    public function formCreateAction() {
        $this->setView('masterLiga', 'formCreate')->render();
    }

    /**
     * @return void
     */
    public function formCloseAction() {
        $this->setView('masterLiga', 'formClose')->render();
    }

    /**
     * @return void
     */
    public function formGamesAction() {
        $this->setView('masterLiga', 'formGames')->render();
    }

    /**
     * @return void
     */
    public function formSaleAction() {
        $this->setView('masterLiga', 'formSale')->render();
    }

    /**
     * @return void
     */
    public function formRewardAction() {
        $this->setView('masterLiga', 'formReward')->render();
    }

    /**
     * @return void
     */
    public function FormPunishAction() {
        $this->setView('masterLiga', 'FormPunish')->render();
    }

    /**
     * @return void
     */
    public function formConfigurationAction() {

        $fields = array(
            'id_temporada' => 'integer',
            'st_painel_ativo' => 'boolean',
            'st_negociacao' => 'boolean',
            'st_compra_multa' => 'boolean',
            'st_reduzir_salario' => 'boolean',
            'st_mostrar_salario' => 'boolean',
            'nu_premio_variacao' => 'integer',
            'nu_premio_empate' => 'integer',
            'nu_premio_gol' => 'integer',
            'nu_multa_vermelho' => 'integer',
            'nu_multa_amarelo' => 'integer',
            'nu_multa_wo' => 'integer',
            'nu_per_compra_multa' => 'integer',
            'nu_multa_recisao_contrato' => 'integer',
            'nu_dias_confirmar_resultado' => 'integer',
            'nu_horas_finalizar_leilao' => 'integer',
            'nu_perc_negociacao' => 'integer',
            'nu_relacao_passe_salario' => 'integer',
            'nu_premio_vitoria' => 'integer',
            'dt_inicio_draft' => 'date'
        );

        $configuracao = current(\br\com\cf\app\model\ModelConfiguracao::factory()->findByParam(array('id_temporada' => 2)));

        $this->setView('masterLiga', 'formConfiguration')
                ->set('fields', $fields)
                ->set('configuracao', $configuracao)
                ->render();
    }

}