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
        $this->setView('jogador', 'list')->render();
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
                    0 => array('j.id_jogador' => 'id_jogador'),
                    1 => array('j.nm_abreviado' => 'nm_abreviado'),
                    2 => array('j.nm_completo' => 'nm_completo'),
                    3 => array('j.dt_nascimento' => 'dt_nascimento'),
                    4 => array('j.nu_altura' => 'nu_altura'),
                    5 => array('j.nu_peso' => 'nu_peso'),
                ))
                ->query($query)
                ->params($this->getParams())
                ->make()
                ->output()
        ;



        $this->json($grid);
    }

}