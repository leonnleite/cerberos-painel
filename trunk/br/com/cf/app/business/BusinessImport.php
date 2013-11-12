<?php

namespace br\com\cf\app\business;

use br\com\cf\library\core\business\BusinessAbstract,
    br\com\cf\app\model\ModelJogador,
    br\com\cf\app\model\ModelClube,
    br\com\cf\app\model\ModelSelecao,
    br\com\cf\app\model\ModelPais

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class BusinessImport extends BusinessAbstract
{

    /**
     * @return BusinessImport
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * generateInsertsCountries
     * @return BusinessImport
     * @param integer $beginPageNumber
     * @param integer $endPageNumber
     */
    public function generateListLinksProfilesPlayers ($beginPageNumber = 1, $endPageNumber = 247)
    {
        include('../library/simplehtmldom/simple_html_dom.php');

        for ($active = $beginPageNumber; $active <= $endPageNumber; $active++) {

            $list = '';
            $html = file_get_html("http://sofifa.com/br/fifa13/player/active?page={$active}");

            foreach ($html->find('tr[class="odd"] td[4] a, tr[class="even"] td[4] a') as $e) {
                $list .= "http://sofifa.com{$e->href}\r\n";
            }

            file_put_contents('../doc/importacao/jogadores/links-perfis/lista-links-perfis-jogadores-' . str_pad($active, 3, '0', STR_PAD_LEFT) . '.txt', $list);
        }

        return $this;
    }

    /**
     * generateInsertsCountries
     * @return BusinessImport
     * @param integer $beginPageNumber
     * @param integer $endPageNumber
     */
    public function generateInsertsCountries ($beginPageNumber = 1, $endPageNumber = 4)
    {
        include('../library/simplehtmldom/simple_html_dom.php');

        $sql = '';

        $query = "insert into pais (sq_pais,nm_pais,nm_confederacao,cd_pais) values (%d,'%s','%s','%s');\r\n";

        for ($active = $beginPageNumber; $active <= $endPageNumber; $active++) {

            $html = file_get_html("http://sofifa.com/br/fifa13/nation/browse?page={$active}");

            foreach ($html->find('table[class="responsive"] tr[class="odd"], table[class="responsive"] tr[class="even"]') as $tr) {
                $sql .= sprintf($query, trim(str_replace('/br/fifa13/player/nation/', '', $tr->find('td[3] a', 0)->href)), trim($tr->find('td[3] a', 0)->plaintext), trim($tr->find('td[4]', 0)->plaintext), trim($tr->find('td[5]', 0)->plaintext));
            }
        }

        file_put_contents("../doc/importacao/paises/inserts-paises.sql", $sql);

        return $this;
    }

    /**
     * generateInsertsClubs
     * @return BusinessImport
     * @param integer $beginPageNumber
     * @param integer $endPageNumber
     */
    public function generateInsertsClubs ($beginPageNumber = 1, $endPageNumber = 9)
    {
        include('../library/simplehtmldom/simple_html_dom.php');

        $sql = '';

        $query = "insert into clube (sq_clube,sq_pais,nm_clube) values (%d,%d,%s);\r\n";

        for ($active = $beginPageNumber; $active <= $endPageNumber; $active++) {

            $html = file_get_html("http://sofifa.com/br/fifa13/team/club?page={$active}");

            foreach ($html->find('table[class="responsive"] tr[class="odd"], table[class="responsive"] tr[class="even"]') as $tr) {
                $sql .= sprintf($query, trim(str_replace('/br/fifa13/team/', '', $tr->find('td[3] a', 0)->href)), trim(str_replace('flag country-', '', $tr->find('td[2] img', 0)->class)), '"' . trim($tr->find('td[3] a', 0)->plaintext) . '"');
            }
        }

        file_put_contents("../doc/importacao/clubes/inserts-clubes.sql", $sql);

        return $this;
    }

    /**
     * generateInsertsSelections
     * @return BusinessImport
     */
    public function generateInsertsSelections ()
    {
        include('../library/simplehtmldom/simple_html_dom.php');

        $sql = '';

        $query = "insert into selecao (sq_selecao,sq_pais,nm_selecao) values (%d,%d,%s);\r\n";

        $html = file_get_html("http://sofifa.com/br/fifa13/team/national");

        foreach ($html->find('table[class="responsive"] tr[class="odd"], table[class="responsive"] tr[class="even"]') as $tr) {
            $sql .= sprintf($query, trim(str_replace('/br/fifa13/team/', '', $tr->find('td[3] a', 0)->href)), trim(str_replace('flag country-', '', $tr->find('td[2] img', 0)->class)), '"' . trim($tr->find('td[3] a', 0)->plaintext) . '"');
        }

        file_put_contents("../doc/importacao/selecoes/inserts-selecoes.sql", $sql);

        return $this;
    }

    /**
     * generateInsertsPlayers
     * @return BusinessImport
     */
    public function generateInsertsPlayers ()
    {
        $query = $query = "insert into jogador (
            sq_jogador,
            nm_abreviado,
            nm_completo,
            dt_nascimento,
            nu_altura,
            nu_peso,
            tx_pe_preferido,
            sq_pais,
            nu_overall,
            cd_po_preferida_1,
            cd_po_preferida_2,
            cd_po_preferida_3,
            nu_aceleracao,
            nu_velocidade_final,
            nu_agilidade,
            nu_equilibrio,
            nu_pulo,
            nu_resistencia,
            nu_forca,
            nu_reacao,
            nu_agressao,
            nu_intercepcao,
            nu_posicionamento,
            nu_visao_jogo,
            nu_controle_bola,
            nu_cruzamento,
            nu_drible,
            nu_finalizacao,
            nu_cobranca_falta,
            nu_cabeceio,
            nu_passe_longo,
            nu_passe_curto,
            nu_marcacao,
            nu_forca_chute,
            nu_chute_longe,
            nu_roubada_bola,
            nu_carrinho,
            nu_voleios,
            nu_curva,
            nu_penaltis,
            nu_salto,
            nu_habilidade_mao,
            nu_habilidade_pe,
            nu_reflexo,
            nu_posicionamento_goleiro,
            nu_potencial,
            nu_reputacao_internacional,
            nu_pe_ruim,
            nu_dribles_habilidade,
            tx_ataque,
            tx_defesa,
            sq_clube,
            sq_selecao,
            id_sofifa) values %s\r\n";

        $lists = glob('../doc/importacao/jogadores/links-perfis/lista-links-perfis-jogadores-*.txt');

        foreach ($lists as $active => $list) {
            $links = file($list);
            $values = '';
            foreach ($links as $key => $link) {
                $values .= $this->generateInsertPlayer(trim($link));
            }
            file_put_contents('../doc/importacao/jogadores/inserts/inserts-jogadores-' . str_pad($active, 3, '0', STR_PAD_LEFT) . '.sql', sprintf($query, substr($values, 0, -3) . ';'));
        }

        return $this;
    }

    /**
     * generateInsertPlayer
     * @return string
     * @param string $link
     */
    public function generateInsertPlayer ($link)
    {
        include('../library/simplehtmldom/simple_html_dom.php');

        $values = "('%s',%s,%s,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',%d,%d,'%s'),\r\n";

        $html = file_get_html("{$link}?responsive=off#");

        $sq_jogador = current(explode('-', str_replace('http://sofifa.com/br/fifa13/player/', '', $link)));

        $nm_abreviado = trim($html->find('ul[class="grid-12 breadcrumbs"] li a', 3)->plaintext);

        $container = $html->find('div[class="container-row"]');

        $nm_completo = trim(str_replace(array('Nome completo'), array(''), $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 0)->plaintext));

        $dt_nascimento = trim(str_replace(array('Data de nascimento', ' ', '/'), array('', '', '-'), $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 1)->plaintext));

        $nu_altura = trim(str_replace(array('Altura', 'cm', ' '), array('', '', ''), $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 2)->plaintext));

        $nu_peso = trim(str_replace(array('Peso', 'kg', ' '), array('', '', ''), $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 3)->plaintext));

        $tx_pe_preferido = trim(str_replace(array('Pé preferido', ' '), array('', ''), $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 4)->plaintext));

        $sq_pais = str_replace('/br/fifa13/player/nation/', '', $container[0]->find('div[class="grid-6"] ul[class="no-bullet"] li', 5)->find('a', 0)->href);

        if ($container[1]->find('div[class="grid-3-3 player-team"] h6 a', 0)->innertext) {
            $sq_clube = current(explode('-', str_replace('/br/fifa13/team/', '', $container[1]->find('div[class="grid-3-3 player-team"] a', 0)->href)));
        }

        if ($container[1]->find('div[class="grid-3-3 player-team"] h6 a', 1)->innertext) {
            $sq_selecao = current(explode('-', str_replace('/br/fifa13/team/', '', $container[1]->find('div[class="grid-3-3 player-team"] h6 a', 1)->href)));
        }

        $h6s = $container[2]->find('h6');

        foreach ($h6s as $h6) {

            switch (trim($h6->plaintext)) {

                case 'Posição':
                    $nu_overall = $h6->parent()->find('span', 0)->innertext;
                    $cd_po_preferida_1 = $h6->parent()->find('span', 1)->innertext;
                    $cd_po_preferida_2 = $h6->parent()->find('span', 2)->innertext;
                    $cd_po_preferida_3 = $h6->parent()->find('span', 3)->innertext;
                    break;

                case 'ATTACKING':
                    $nu_cruzamento = $h6->parent()->find('span', 0)->innertext;
                    $nu_finalizacao = $h6->parent()->find('span', 1)->innertext;
                    $nu_cabeceio = $h6->parent()->find('span', 2)->innertext;
                    $nu_passe_curto = $h6->parent()->find('span', 3)->innertext;
                    $nu_voleios = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'POWER':
                    $nu_forca_chute = $h6->parent()->find('span', 0)->innertext;
                    $nu_pulo = $h6->parent()->find('span', 1)->innertext;
                    $nu_resistencia = $h6->parent()->find('span', 2)->innertext;
                    $nu_forca = $h6->parent()->find('span', 3)->innertext;
                    $nu_chute_longe = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'MENTALITY':
                    $nu_agressao = $h6->parent()->find('span', 0)->innertext;
                    $nu_intercepcao = $h6->parent()->find('span', 1)->innertext;
                    $nu_posicionamento = $h6->parent()->find('span', 2)->innertext;
                    $nu_visao_jogo = $h6->parent()->find('span', 3)->innertext;
                    $nu_penaltis = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'DEFESA':
                    $nu_marcacao = $h6->parent()->find('span', 0)->innertext;
                    $nu_roubada_bola = $h6->parent()->find('span', 1)->innertext;
                    $nu_carrinho = $h6->parent()->find('span', 2)->innertext;
                    break;

                case 'SKILL':
                    $nu_drible = $h6->parent()->find('span', 0)->innertext;
                    $nu_curva = $h6->parent()->find('span', 1)->innertext;
                    $nu_cobranca_falta = $h6->parent()->find('span', 2)->innertext;
                    $nu_passe_longo = $h6->parent()->find('span', 3)->innertext;
                    $nu_controle_bola = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'Movimento':
                    $nu_aceleracao = $h6->parent()->find('span', 0)->innertext;
                    $nu_velocidade_final = $h6->parent()->find('span', 1)->innertext;
                    $nu_agilidade = $h6->parent()->find('span', 2)->innertext;
                    $nu_reacao = $h6->parent()->find('span', 3)->innertext;
                    $nu_equilibrio = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'GOALKEEPING':
                    $nu_salto = $h6->parent()->find('span', 0)->innertext;
                    $nu_habilidade_mao = $h6->parent()->find('span', 1)->innertext;
                    $nu_habilidade_pe = $h6->parent()->find('span', 2)->innertext;
                    $nu_posicionamento_goleiro = $h6->parent()->find('span', 3)->innertext;
                    $nu_reflexo = $h6->parent()->find('span', 4)->innertext;
                    break;

                case 'Outros':
                    $nu_potencial = $h6->parent()->find('span', 0)->innertext;
                    $nu_reputacao_internacional = $h6->parent()->find('img', 0)->title;
                    $nu_pe_ruim = $h6->parent()->find('img', 1)->title;
                    $nu_dribles_habilidade = $h6->parent()->find('img', 2)->title;
                    $tx_ataque = $h6->parent()->find('span', 1)->innertext;
                    $tx_defesa = $h6->parent()->find('span', 2)->innertext;
                    $id_sofifa = trim(str_replace(array('ID', ' '), array('', ''), $h6->parent()->find('li', 6)->plaintext));
                    break;
            }
        }

        //@todo Debugger!!!
//        print '<hr>posicao<hr>';
//        var_dump($nu_overall, $cd_po_preferida_1, $cd_po_preferida_2, $cd_po_preferida_3);
//        print '<hr>ataque<hr>';
//        var_dump($nu_cruzamento, $nu_finalizacao, $nu_cabeceio, $nu_passe_curto, $nu_voleios);
//        print '<hr>forca<hr>';
//        var_dump($nu_forca_chute, $nu_pulo, $nu_resistencia, $nu_forca, $nu_chute_longe);
//        print '<hr>mentalidade<hr>';
//        var_dump($nu_agressao, $nu_intercepcao, $nu_posicionamento, $nu_visao_jogo, $nu_penaltis);
//        print '<hr>abilidades<hr>';
//        var_dump($nu_drible, $nu_curva, $nu_cobranca_falta, $nu_passe_longo, $nu_controle_bola);
//        print '<hr>defesa<hr>';
//        var_dump($nu_marcacao, $nu_roubada_bola, $nu_carrinho);
//        print '<hr>movimento<hr>';
//        var_dump($nu_aceleracao, $nu_velocidade_final, $nu_agilidade, $nu_reacao, $nu_equilibrio);
//        print '<hr>goleiro<hr>';
//        var_dump($nu_salto, $nu_habilidade_mao, $nu_habilidade_pe, $nu_posicionamento_goleiro, $nu_reflexo);
//        print '<hr>outros<hr>';
//        var_dump($nu_potencial, $nu_reputacao_internacional, $nu_pe_ruim, $nu_dribles_habilidade, $tx_ataque, $tx_defesa, $id_sofifa);
//        exit;

        return sprintf($values, $id_sofifa, '"' . $nm_abreviado . '"', '"' . $nm_completo . '"', $dt_nascimento, $nu_altura, $nu_peso, $tx_pe_preferido, $sq_pais, $nu_overall, $cd_po_preferida_1, $cd_po_preferida_2, $cd_po_preferida_3, $nu_aceleracao, $nu_velocidade_final, $nu_agilidade, $nu_equilibrio, $nu_pulo, $nu_resistencia, $nu_forca, $nu_reacao, $nu_agressao, $nu_intercepcao, $nu_posicionamento, $nu_visao_jogo, $nu_controle_bola, $nu_cruzamento, $nu_drible, $nu_finalizacao, $nu_cobranca_falta, $nu_cabeceio, $nu_passe_longo, $nu_passe_curto, $nu_marcacao, $nu_forca_chute, $nu_chute_longe, $nu_roubada_bola, $nu_carrinho, $nu_voleios, $nu_curva, $nu_penaltis, $nu_salto, $nu_habilidade_mao, $nu_habilidade_pe, $nu_reflexo, $nu_posicionamento_goleiro, $nu_potencial, $nu_reputacao_internacional, $nu_pe_ruim, $nu_dribles_habilidade, $tx_ataque, $tx_defesa, $sq_clube, $sq_selecao, $sq_jogador);
    }

    /**
     * mergerInsertsPlayers
     * @return BusinessImport
     */
    public function mergeInsertsPlayers ()
    {

        $sql = '';

        $lists = glob('../doc/importacao/jogadores/inserts/inserts-jogadores-*.sql');

        foreach ($lists as $list) {
            $sql .= file_get_contents($list);
        }

        file_put_contents('../doc/importacao/jogadores/inserts/000-merged.sql', $sql);

        return $this;
    }

    /**
     * updatePhotosPlayers
     * @return BusinessImport
     */
    public function updatePhotosPlayers ()
    {
        $jogadores = ModelJogador::factory()->findAll(0, 100000);

        foreach ($jogadores as $index => $jogador) {
            file_put_contents("../doc/importacao/jogadores/fotos/{$jogador->sq_jogador}.png", file_get_contents("http://cdn.content.easports.com/fifa/fltOnlineAssets/2013/fut/items/images/players/web/{$jogador->sq_jogador}.png"));
        }

        return $this;
    }

    /**
     * updatePhotosClubs
     * @return BusinessImport
     */
    public function updatePhotosClubs ()
    {

        include('../library/simplehtmldom/simple_html_dom.php');

        $clubes = ModelClube::factory()->findAll(0, 1000000);

        foreach ($clubes as $index => $clube) {

            $html = file_get_html("http://sofifa.com/br/fifa13/team/{$clube->sq_clube}?responsive=off#");
            $container = $html->find('div[class="container-row"]');

            $url = $container[0]->find('div[class="grid-1"] img', 0)->src;

            if ($url) {
                file_put_contents("../doc/importacao/clubes/fotos/logos/{$clube->sq_clube}.png", file_get_contents($url));
                file_put_contents("../doc/importacao/clubes/fotos/uniformes/{$clube->sq_clube}-1.png", file_get_contents("http://cdn.content.easports.com/fifa/fltOnlineAssets/2013/fut/items/images/kits/web/j0_{$clube->sq_clube}.png"));
                file_put_contents("../doc/importacao/clubes/fotos/uniformes/{$clube->sq_clube}-2.png", file_get_contents("http://cdn.content.easports.com/fifa/fltOnlineAssets/2013/fut/items/images/kits/web/j1_{$clube->sq_clube}.png"));
            }
        }

        return $this;
    }

    /**
     * updatePhotosClubs
     * @return BusinessImport
     */
    public function updatePhotosSelections ()
    {

        include('../library/simplehtmldom/simple_html_dom.php');

        $selecoes = ModelSelecao::factory()->findAll(0, 1000000);

        foreach ($selecoes as $index => $selecao) {

            $html = file_get_html("http://sofifa.com/br/fifa13/team/{$selecao->sq_selecao}?responsive=off#");
            $container = $html->find('div[class="container-row"]');

            $url = $container[0]->find('div[class="grid-1"] img', 0)->src;

            if ($url) {
                file_put_contents("../doc/importacao/selecoes/fotos/logos/{$selecao->sq_selecao}.png", file_get_contents($url));
                file_put_contents("../doc/importacao/selecoes/fotos/uniformes/{$selecao->sq_selecao}-1.png", file_get_contents("http://cdn.content.easports.com/fifa/fltOnlineAssets/2013/fut/items/images/kits/web/j0_{$selecao->sq_selecao}.png"));
                file_put_contents("../doc/importacao/selecoes/fotos/uniformes/{$selecao->sq_selecao}-2.png", file_get_contents("http://cdn.content.easports.com/fifa/fltOnlineAssets/2013/fut/items/images/kits/web/j1_{$selecao->sq_selecao}.png"));
            }
        }

        return $this;
    }

}