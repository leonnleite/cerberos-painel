<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerSelecao extends ControllerAbstract
{

    /**
     * @return void
     */
    public function indexAction ()
    {
        $this->setView('selecao', 'index')->render();
    }

    /**
     * @return void
     */
    public function searchAction ()
    {
        $this->setView('selecao', 'search')->render();
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $this->setView('selecao', 'list')->render();
    }

    /**
     * @return void
     */
    public function loadGridSearchAction ()
    {
        $query = 'selecao s inner join pais p on p.id_pais = s.id_pais';

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_selecao')
                ->columns(array(
                    0 => array('s.id_selecao' => 'id_selecao'),
                    1 => array('s.nm_selecao' => 'nm_selecao'),
                    2 => array('p.nm_pais' => 'nm_pais')
                ))
                ->query($query)
                ->params($this->getParams())
                ->make()
                ->output()
        ;



        $this->json($grid);
    }

}