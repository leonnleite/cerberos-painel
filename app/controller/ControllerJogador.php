<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerJogador extends ControllerAbstract
{

    /**
     * @return void
     */
    public function indexAction ()
    {
        $this->setView('jogador', 'index')->render();
    }

    /**
     * @return void
     */
    public function searchAction ()
    {
        $this->setView('jogador', 'search')->render();
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $this->setView('jogador', 'list')
                ->set('columns', array(
                    array('j.nm_abreviado' => 'nm_abreviado'),
                    array('j.nm_completo' => 'nm_completo'),
                    array('j.dt_nascimento' => 'dt_nascimento'),
                    array('j.nu_altura' => 'nu_altura'),
                    array('j.nu_peso' => 'nu_peso'),
                    array('j.tx_pe_preferido' => 'tx_pe_preferido'),
                    array('j.id_pais' => 'id_pais'),
                    array('j.nu_overall' => 'nu_overall'),
//                    array('j.cd_po_preferida_1' => 'cd_po_preferida_1'),
//                    array('j.cd_po_preferida_2' => 'cd_po_preferida_2'),
//                    array('j.cd_po_preferida_3' => 'cd_po_preferida_3'),
//                    array('j.nu_aceleracao' => 'nu_aceleracao'),
//                    array('j.nu_velocidade_final' => 'nu_velocidade_final'),
//                    array('j.nu_agilidade' => 'nu_agilidade'),
//                    array('j.nu_equilibrio' => 'nu_equilibrio'),
//                    array('j.nu_pulo' => 'nu_pulo'),
//                    array('j.nu_resistencia' => 'nu_resistencia'),
//                    array('j.nu_forca' => 'nu_forca'),
//                    array('j.nu_reacao' => 'nu_reacao'),
//                    array('j.nu_agressao' => 'nu_agressao'),
//                    array('j.nu_intercepcao' => 'nu_intercepcao'),
//                    array('j.nu_posicionamento' => 'nu_posicionamento'),
//                    array('j.nu_visao_jogo' => 'nu_visao_jogo'),
//                    array('j.nu_controle_bola' => 'nu_controle_bola'),
//                    array('j.nu_cruzamento' => 'nu_cruzamento'),
//                    array('j.nu_drible' => 'nu_drible'),
//                    array('j.nu_finalizacao' => 'nu_finalizacao'),
//                    array('j.nu_cobranca_falta' => 'nu_cobranca_falta'),
//                    array('j.nu_cabeceio' => 'nu_cabeceio'),
//                    array('j.nu_passe_longo' => 'nu_passe_longo'),
//                    array('j.nu_passe_curto' => 'nu_passe_curto'),
//                    array('j.nu_marcacao' => 'nu_marcacao'),
//                    array('j.nu_forca_chute' => 'nu_forca_chute'),
//                    array('j.nu_chute_longe' => 'nu_chute_longe'),
//                    array('j.nu_roubada_bola' => 'nu_roubada_bola'),
//                    array('j.nu_carrinho' => 'nu_carrinho'),
//                    array('j.nu_voleios' => 'nu_voleios'),
//                    array('j.nu_curva' => 'nu_curva'),
//                    array('j.nu_penaltis' => 'nu_penaltis'),
//                    array('j.nu_salto' => 'nu_salto'),
//                    array('j.nu_habilidade_mao' => 'nu_habilidade_mao'),
//                    array('j.nu_habilidade_pe' => 'nu_habilidade_pe'),
//                    array('j.nu_reflexo' => 'nu_reflexo'),
//                    array('j.nu_posicionamento_goleiro' => 'nu_posicionamento_goleiro'),
//                    array('j.nu_potencial' => 'nu_potencial'),
//                    array('j.nu_reputacao_internacional' => 'nu_reputacao_internacional'),
//                    array('j.nu_pe_ruim' => 'nu_pe_ruim'),
//                    array('j.nu_dribles_habilidade' => 'nu_dribles_habilidade'),
//                    array('j.tx_ataque' => 'tx_ataque'),
//                    array('j.tx_defesa' => 'tx_defesa'),
//                    array('j.id_clube' => 'id_clube'),
//                    array('j.id_selecao' => 'id_selecao'),
//                    array('j.id_sofifa' => 'id_sofifa')
                ))
                ->render();
    }

    /**
     * @return void
     */
    public function loadGridSearchAction ()
    {
        $query = 'jogador j';

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_jogador')
                ->columns(array(
                    array('j.nm_abreviado' => 'nm_abreviado'),
                    array('j.nm_completo' => 'nm_completo'),
                    array('j.dt_nascimento' => 'dt_nascimento'),
                    array('j.nu_altura' => 'nu_altura'),
                    array('j.nu_peso' => 'nu_peso'),
                    array('j.tx_pe_preferido' => 'tx_pe_preferido'),
                    array('j.id_pais' => 'id_pais'),
                    array('j.nu_overall' => 'nu_overall'),
                    array('j.cd_po_preferida_1' => 'cd_po_preferida_1'),
                    array('j.cd_po_preferida_2' => 'cd_po_preferida_2'),
                    array('j.cd_po_preferida_3' => 'cd_po_preferida_3'),
                    array('j.nu_aceleracao' => 'nu_aceleracao'),
                    array('j.nu_velocidade_final' => 'nu_velocidade_final'),
                    array('j.nu_agilidade' => 'nu_agilidade'),
                    array('j.nu_equilibrio' => 'nu_equilibrio'),
                    array('j.nu_pulo' => 'nu_pulo'),
                    array('j.nu_resistencia' => 'nu_resistencia'),
                    array('j.nu_forca' => 'nu_forca'),
                    array('j.nu_reacao' => 'nu_reacao'),
                    array('j.nu_agressao' => 'nu_agressao'),
                    array('j.nu_intercepcao' => 'nu_intercepcao'),
                    array('j.nu_posicionamento' => 'nu_posicionamento'),
                    array('j.nu_visao_jogo' => 'nu_visao_jogo'),
                    array('j.nu_controle_bola' => 'nu_controle_bola'),
                    array('j.nu_cruzamento' => 'nu_cruzamento'),
                    array('j.nu_drible' => 'nu_drible'),
                    array('j.nu_finalizacao' => 'nu_finalizacao'),
                    array('j.nu_cobranca_falta' => 'nu_cobranca_falta'),
                    array('j.nu_cabeceio' => 'nu_cabeceio'),
                    array('j.nu_passe_longo' => 'nu_passe_longo'),
                    array('j.nu_passe_curto' => 'nu_passe_curto'),
                    array('j.nu_marcacao' => 'nu_marcacao'),
                    array('j.nu_forca_chute' => 'nu_forca_chute'),
                    array('j.nu_chute_longe' => 'nu_chute_longe'),
                    array('j.nu_roubada_bola' => 'nu_roubada_bola'),
                    array('j.nu_carrinho' => 'nu_carrinho'),
                    array('j.nu_voleios' => 'nu_voleios'),
                    array('j.nu_curva' => 'nu_curva'),
                    array('j.nu_penaltis' => 'nu_penaltis'),
                    array('j.nu_salto' => 'nu_salto'),
                    array('j.nu_habilidade_mao' => 'nu_habilidade_mao'),
                    array('j.nu_habilidade_pe' => 'nu_habilidade_pe'),
                    array('j.nu_reflexo' => 'nu_reflexo'),
                    array('j.nu_posicionamento_goleiro' => 'nu_posicionamento_goleiro'),
                    array('j.nu_potencial' => 'nu_potencial'),
                    array('j.nu_reputacao_internacional' => 'nu_reputacao_internacional'),
                    array('j.nu_pe_ruim' => 'nu_pe_ruim'),
                    array('j.nu_dribles_habilidade' => 'nu_dribles_habilidade'),
                    array('j.tx_ataque' => 'tx_ataque'),
                    array('j.tx_defesa' => 'tx_defesa'),
                    array('j.id_clube' => 'id_clube'),
                    array('j.id_selecao' => 'id_selecao'),
                    array('j.id_sofifa' => 'id_sofifa')
                ))
                ->query($query)
                ->params($this->getParams())
                ->make('and')
                ->output()
        ;



        $this->json($grid);
    }

}