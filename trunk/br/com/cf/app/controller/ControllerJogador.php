<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerJogador extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {
        $this->setView('jogador', 'index')->render();
    }

    /**
     * @return void
     */
    public function searchAction() {
        $this->setView('jogador', 'search')->render();
    }

    /**
     * @return void
     */
    public function editAction() {
        try {

            \br\com\cf\app\model\ModelJogador::factory()->update($this->getParams());

            $response = array('status' => 'success', 'message' => 'Alteração concluída com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function listAction() {
        $this->setView('jogador', 'list')
                ->set('columns', array(
                    array('j.id_jogador' => 'ID'),
//                    array('j.nm_abreviado' => 'nm_abreviado'),
                    array('j.nm_completo' => 'Nome'),
                    array('j.dt_nascimento' => 'Nascimento'),
                    array('j.nu_altura' => 'Altura'),
                    array('j.nu_peso' => 'Peso'),
                    array('j.tx_pe_preferido' => 'Pe'),
                    array('j.id_pais' => 'Pais'),
                    array('j.nu_overall' => 'Overrall'),
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
                    array('j.id_clube' => 'Clube'),
                    array('j.id_selecao' => 'Seleção'),
//                    array('j.id_sofifa' => 'id_sofifa'),
                ))
                ->render();
    }

    /**
     * @return void
     */
    public function loadGridSearchAction() {

        $query = 'jogador j '
                . 'inner join pais p on p.id_pais = j.id_pais '
                . 'inner join selecao s on s.id_selecao = j.id_selecao '
                . 'inner join clube c on c.id_clube = j.id_clube '
        ;

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_jogador')
                ->columns(array(
                    array('j.id_jogador' => 'id_jogador'),
//                    array('j.nm_abreviado' => 'nm_abreviado'),
                    array('j.nm_completo' => 'nm_completo'),
                    array('j.dt_nascimento' => 'dt_nascimento'),
                    array('j.nu_altura' => 'nu_altura'),
                    array('j.nu_peso' => 'nu_peso'),
                    array('j.tx_pe_preferido' => 'tx_pe_preferido'),
                    array('p.nm_pais' => 'nm_pais'),
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
                    array('j.id_clube' => 'id_clube'),
                    array('j.id_selecao' => 'id_selecao'),
//                    array('j.id_sofifa' => 'id_sofifa'),
                ))
                ->query($query)
                ->params($this->getParams())
                ->make('and')
                ->output()
        ;



        $this->json($grid);
    }

    /**
     * @return void
     */
    public function formEditAction() {
        try {

            $jogador = \br\com\cf\app\model\ModelJogador::factory()->find($this->getParam('id_jogador'));

            $jogador->nm_id_selecao = \br\com\cf\app\model\ModelSelecao::factory()->find($jogador->id_selecao)->nm_selecao;
            $jogador->nm_id_pais = \br\com\cf\app\model\ModelPais::factory()->find($jogador->id_pais)->nm_pais;
            $jogador->nm_id_clube = \br\com\cf\app\model\ModelClube::factory()->find($jogador->id_clube)->nm_clube;

            $this->setView('jogador', 'formEdit')
                    ->set('jogador', $jogador)
                    ->set('fields', array(
                        array('id_jogador' => 'ID'),
                        array('nm_abreviado' => 'N. Abreviado'),
                        array('nm_completo' => 'N. Completo'),
                        array('dt_nascimento' => 'Nascimento'),
                        array('nu_altura' => 'Altura'),
                        array('nu_peso' => 'Peso'),
                        array('tx_pe_preferido' => 'Pé preferido'),
                        array('id_pais' => 'Pais'),
                        array('nu_overall' => 'Overall'),
                        array('cd_po_preferida_1' => 'Posição preferida I'),
                        array('cd_po_preferida_2' => 'Posição preferida II'),
                        array('cd_po_preferida_3' => 'Posição preferida III'),
                        array('nu_aceleracao' => 'Aceleracao'),
                        array('nu_velocidade_final' => 'Velocidade final'),
                        array('nu_agilidade' => 'Agilidade'),
                        array('nu_equilibrio' => 'Equilibrio'),
                        array('nu_pulo' => 'Pulo'),
                        array('nu_resistencia' => 'Resistência'),
                        array('nu_forca' => 'Força'),
                        array('nu_reacao' => 'Reação'),
                        array('nu_agressao' => 'Agressão'),
                        array('nu_intercepcao' => 'Intercepção'),
                        array('nu_posicionamento' => 'Posicionamento'),
                        array('nu_visao_jogo' => 'Visão de jogo'),
                        array('nu_controle_bola' => 'Coontrole de bola'),
                        array('nu_cruzamento' => 'Cruzamento'),
                        array('nu_drible' => 'Drible'),
                        array('nu_finalizacao' => 'Finalização'),
                        array('nu_cobranca_falta' => 'Cobrança de falta'),
                        array('nu_cabeceio' => 'Cabeceio'),
                        array('nu_passe_longo' => 'Passe longo'),
                        array('nu_passe_curto' => 'Passe curto'),
                        array('nu_marcacao' => 'Marcação'),
                        array('nu_forca_chute' => 'Fora do chute'),
                        array('nu_chute_longe' => 'Chute longe'),
                        array('nu_roubada_bola' => 'Roubada de bola'),
                        array('nu_carrinho' => 'Carrinho'),
                        array('nu_voleios' => 'Voleios'),
                        array('nu_curva' => 'Curva'),
                        array('nu_penaltis' => 'Penaltis'),
                        array('nu_salto' => 'Salto'),
                        array('nu_habilidade_mao' => 'Habilidade com a mão'),
                        array('nu_habilidade_pe' => 'Habilidade com o pé'),
                        array('nu_reflexo' => 'Reflexo'),
                        array('nu_posicionamento_goleiro' => 'Posicionamento goleiro'),
                        array('nu_potencial' => 'Potencial'),
                        array('nu_reputacao_internacional' => 'Reputação internacional'),
                        array('nu_pe_ruim' => 'Pé ruim'),
                        array('nu_dribles_habilidade' => 'Dribles'),
                        array('tx_ataque' => 'Ataque'),
                        array('tx_defesa' => 'Defesa'),
                        array('id_clube' => 'Clube'),
                        array('id_selecao' => 'Seleção'),
                        array('id_sofifa' => 'ID FIFA')
                    ))
                    ->render();
        } catch (\Exception $e) {
            print('Ocorreu um erro ao tentar carregar as informações solicitadas!');
        }
    }

    /**
     * @return void
     */
    public function detailAction() {
        try {

            $jogador = \br\com\cf\app\model\ModelJogador::factory()->find($this->getParam('id_jogador'));

            $jogador->nm_selecao = \br\com\cf\app\model\ModelSelecao::factory()->find($jogador->id_selecao)->nm_selecao;
            $jogador->nm_pais = \br\com\cf\app\model\ModelPais::factory()->find($jogador->id_pais)->nm_pais;
            $jogador->nm_clube = \br\com\cf\app\model\ModelClube::factory()->find($jogador->id_clube)->nm_clube;

            $this->setView('jogador', 'detail')
                    ->set('jogador', $jogador)
                    ->set('attrs', array(
//                        array('tx_ataque' => 'Ataque'),
//                        array('tx_defesa' => 'Defesa'),
//                        array('tx_pe_preferido' => 'Pé preferido'),
//                        array('id_jogador' => 'ID'),
//                        array('nm_abreviado' => 'N. Abreviado'),
//                        array('nm_completo' => 'N. Completo'),
//                        array('dt_nascimento' => 'Nascimento'),
//                        array('nu_altura' => 'Altura'),
//                        array('nu_peso' => 'Peso'),
//                        array('id_pais' => 'Pais'),
//                        array('cd_po_preferida_1' => 'Posição preferida I'),
//                        array('cd_po_preferida_2' => 'Posição preferida II'),
//                        array('cd_po_preferida_3' => 'Posição preferida III'),
                        array('nu_overall' => 'Overall'),
                        array('nu_aceleracao' => 'Aceleracao'),
                        array('nu_velocidade_final' => 'Velocidade final'),
                        array('nu_agilidade' => 'Agilidade'),
                        array('nu_equilibrio' => 'Equilibrio'),
                        array('nu_pulo' => 'Pulo'),
                        array('nu_resistencia' => 'Resistência'),
                        array('nu_forca' => 'Força'),
                        array('nu_reacao' => 'Reação'),
                        array('nu_agressao' => 'Agressão'),
                        array('nu_intercepcao' => 'Intercepção'),
                        array('nu_posicionamento' => 'Posicionamento'),
                        array('nu_visao_jogo' => 'Visão de jogo'),
                        array('nu_controle_bola' => 'Coontrole de bola'),
                        array('nu_cruzamento' => 'Cruzamento'),
                        array('nu_drible' => 'Drible'),
                        array('nu_finalizacao' => 'Finalização'),
                        array('nu_cobranca_falta' => 'Cobrança de falta'),
                        array('nu_cabeceio' => 'Cabeceio'),
                        array('nu_passe_longo' => 'Passe longo'),
                        array('nu_passe_curto' => 'Passe curto'),
                        array('nu_marcacao' => 'Marcação'),
                        array('nu_forca_chute' => 'Fora do chute'),
                        array('nu_chute_longe' => 'Chute longe'),
                        array('nu_roubada_bola' => 'Roubada de bola'),
                        array('nu_carrinho' => 'Carrinho'),
                        array('nu_voleios' => 'Voleios'),
                        array('nu_curva' => 'Curva'),
                        array('nu_penaltis' => 'Penaltis'),
                        array('nu_salto' => 'Salto'),
                        array('nu_habilidade_mao' => 'Habilidade com a mão'),
                        array('nu_habilidade_pe' => 'Habilidade com o pé'),
                        array('nu_reflexo' => 'Reflexo'),
                        array('nu_posicionamento_goleiro' => 'Posicionamento goleiro'),
                        array('nu_potencial' => 'Potencial'),
                        array('nu_reputacao_internacional' => 'Reputação internacional'),
                        array('nu_pe_ruim' => 'Pé ruim'),
                        array('nu_dribles_habilidade' => 'Dribles'),
//                        array('id_clube' => 'Clube'),
//                        array('id_selecao' => 'Seleção'),
//                        array('id_sofifa' => 'ID FIFA')
                    ))
                    ->render();
        } catch (\Exception $e) {
            print('Ocorreu um erro ao tentar carregar as informações solicitadas!');
        }
    }

    /**
     * @return void
     */
    public function formPhotoAction() {
        $this->setView('jogador', 'formPhoto')->render();
    }

    /**
     * @return void
     */
    public function uploadPhotoAction() {

        $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
        $max_file_size = 200000000000 * 10240; #200kb
        $nw = $nh = 100; # image with # height

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image'])) {
                if (!$_FILES['image']['error'] && $_FILES['image']['size'] < $max_file_size) {
                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    if (in_array($ext, $valid_exts)) {
                        $path = CF_APP_PUBLIC_PATH . '/uploads/' . uniqid() . '.' . $ext;
                        $size = getimagesize($_FILES['image']['tmp_name']);

                        $x = (int) $_POST['x'];
                        $y = (int) $_POST['y'];
                        $w = (int) $_POST['w'] ? $_POST['w'] : $size[0];
                        $h = (int) $_POST['h'] ? $_POST['h'] : $size[1];

                        $data = file_get_contents($_FILES['image']['tmp_name']);
                        $vImg = imagecreatefromstring($data);
                        $dstImg = imagecreatetruecolor($nw, $nh);
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
                        imagejpeg($dstImg, $path);
                        imagedestroy($dstImg);
                        echo "<img src='$path' />";
                    } else {
                        echo 'unknown problem!';
                    }
                } else {
                    echo 'file is too small or large';
                }
            } else {
                echo 'file not set';
            }
        } else {
            echo 'bad request!';
        }
    }

}