<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerMasterLiga extends ControllerAbstract
{

    /**
     * @return void
     */
    public function indexAction ()
    {
        $this->setView('masterLiga', 'index')->render();
    }

    /**
     * @return void
     */
    public function formCreateAction ()
    {

        $series = array();

        $activeSeries = \br\com\cf\app\model\ModelSerie::factory()->retrieveActiveSeries();

        foreach ($activeSeries as $serie) {

            $usuarios = \br\com\cf\app\model\ModelUsuario::factory()->findByParam(array('id_serie' => $serie->id_serie));

            foreach ($usuarios as $usuario) {
                unset($usuario->fg_perfil);
                unset($usuario->tx_senha);
                $series[$serie->nm_serie][] = $usuario;
            }
        }

        $this->setView('masterLiga', 'formCreate')
                ->set('series', $series)
                ->render();
    }

    /**
     * @return void
     */
    public function createAction ()
    {

        //@todo persistir os usuarios...

        $params = $this->getParams();

        $series = array();

        foreach ($params['id_usuario'] as $key => $on) {
            $tmp = explode(':', $key);
            $series[$tmp[0]][] = $tmp[1];
        }

        $campeonato = \br\com\cf\app\model\ModelCampeonato::factory();
        $temporada = \br\com\cf\app\model\ModelTemporada::factory();
        $campeonatoXusuario = \br\com\cf\app\model\ModelCampeonatoXUsuario::factory();
        $jogo = \br\com\cf\app\model\ModelJogo::factory();

        try {

            $campeonato->beginTransaction();

            print $idTemporada = $temporada->insert(array('id_temporada_status' => 1, 'dt_inicial' => $params['dt_inicial']));

            print $idCampeonato = $campeonato->insert(array('id_temporada' => $idTemporada, 'nm_campeonato' => $params['nm_campeonato']));

            //Associar usuarios ao campeonato...
            foreach ($params['id_usuario'] as $key => $value) {
                $tmp = explode(':', $key);
                $campeonatoXusuario->insert(array('id_usuario' => $tmp[1], 'id_campeonato' => $idCampeonato));
            }

            //Persistir jogos...
            foreach ($series as $serie => $usuarios) {
                foreach ($usuarios as $i => $current) {
                    foreach ($usuarios as $j => $invite) {
                        if ($current != $invite) {
                            $idJogo = $jogo->insert(array('id_usuario_casa' => $current, 'id_usuario_visitante' => $invite, 'id_temporada' => $idTemporada, 'id_status' => 1));
                            \br\com\cf\app\model\ModelJogoXCampeonato::factory()->insert(array('id_jogo' => $idJogo, 'id_campeonato' => $idCampeonato));
                        }
                    }
                }
            }

            $campeonato->commit();

            $response = array('status' => 'success', 'message' => 'Master Liga criada com sucesso!');
        } catch (\Exception $e) {
            $campeonato->rollback();
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function formCloseAction ()
    {
        $this->setView('masterLiga', 'formClose')->render();
    }

    /**
     * @return void
     */
    public function closeAction ()
    {

        $temporada = \br\com\cf\app\model\ModelTemporada::factory();

        try {

            $idTemporada = $temporada->active()->id_temporada;

            $temporada->update(array('id_temporada' => $idTemporada, 'dt_final' => date('Y-m-d')));

            $response = array('status' => 'success', 'message' => 'Master Liga encerrada com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function formGamesAction ()
    {
        $this->setView('masterLiga', 'formGames')->render();
    }

    /**
     * @return void
     */
    public function loadGridGamesAction ()
    {

        $query = 'jogo j '
                . 'inner join jogo_status s on s.id_status = j.id_status '
                . 'inner join usuario c on c.id_usuario = j.id_usuario_casa '
                . 'inner join usuario v on v.id_usuario = j.id_usuario_visitante '
                . 'inner join temporada t on t.id_temporada = j.id_temporada '
                . 'inner join serie e on e.id_serie = c.id_serie '
                . 'where t.id_temporada = ' . \br\com\cf\app\model\ModelTemporada::factory()->active()->id_temporada
        ;

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_jogo')
                ->columns(array(
                    array('j.id_jogo' => 'id_jogo'),
                    array('e.nm_serie' => 'nm_serie'),
                    array('c.nm_usuario' => 'casa'),
                    array('s.nm_status' => 'nm_status'),
                    array('v.nm_usuario' => 'visitante'),
                    array('s.nm_status' => 'nm_status'),
                    array('s.nm_status' => 'nm_status'),
                    //
                    array('c.nm_equipe' => 'eq_casa'),
                    array('v.nm_equipe' => 'eq_visitante'),
                    array('s.id_status' => 'id_status'),
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
    public function activateGameAction ()
    {
        $params = array('id_status' => 2, 'id_jogo' => $this->getParam('id_jogo'));

        try {
            \br\com\cf\app\model\ModelJogo::factory()->update($params);
            $response = array('status' => 'success', 'message' => 'Partida liberada com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

    /**
     * @return void
     */
    public function formSaleAction ()
    {
        $this->setView('masterLiga', 'formSale')->render();
    }

    /**
     * @return void
     */
    public function formRewardAction ()
    {
        $this->setView('masterLiga', 'formReward')->render();
    }

    /**
     * @return void
     */
    public function formPunishAction ()
    {
        $this->setView('masterLiga', 'FormPunish')->render();
    }

    /**
     * @return void
     */
    public function formConfigurationAction ()
    {

        $columns = array(
            0 => array(
                'st_painel_ativo' => 'Permitir Acesso PAINEL', #manutencao
                'st_negociacao' => 'Permitir Negociações', #compra, venda e troca de jogadores
                'st_compra_multa' => 'Permitir Comprar por Multa', #rouba o jogador e paga a multa sugerida
                'st_gerenciar_salario' => 'Permitir Gerenciar Salários', #trava a opcao de alterar salarios
            ),
            1 => array(
                'nu_per_compra_multa' => '% Acressímo Compra por Multa', #esse % serah somado total vez que um jogador for robado, quanto for permitido gerenciar salarios
                'nu_multa_recisao_contrato' => 'Multa por recisão de contrato', #esse valor serah debitado do saldo do usuario quando um jogador for demitido
                'nu_dias_confirmar_resultado' => 'Qtd. de dia para confirmar resultado', # tempo maximo para confirmar o resultado do jogo
                'nu_relacao_passe_salario' => 'Relação passe salário', #?????
                'nu_premio_vitoria' => 'Prêmio por vitória', # serah o valor credito na conta do usuario quando ele ganhar um partida
            ),
            2 => array(
                'nu_premio_variacao' => 'Variação do Prêmio',
                'nu_premio_empate' => 'Prêmio Empate',
                'nu_premio_gol' => 'Prêmio Gol',
                'nu_multa_vermelho' => 'Multa Cartão Vermelho',
                'nu_multa_amarelo' => 'Multa Cartão Amarelo',
                'nu_multa_wo' => 'Multa WO'
            )
        );

        $configuracao = current(\br\com\cf\app\model\ModelConfiguracao::factory()->findByParam(array('id_configuracao' => 1)));

        $this->setView('masterLiga', 'formConfiguration')
                ->set('columns', $columns)
                ->set('configuracao', $configuracao)
                ->render();
    }

    /**
     * @return void
     */
    public function configurationAction ()
    {

        try {
            \br\com\cf\app\model\ModelConfiguracao::factory()->update($this->getParams());
            $response = array('status' => 'success', 'message' => 'Configurações da Master Liga alteração com sucesso!');
        } catch (\Exception $e) {
            $response = array('status' => 'error', 'message' => $e->getMessage());
        }

        $this->json($response);
    }

}