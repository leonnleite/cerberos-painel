<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerClube extends ControllerAbstract
{

    /**
     * @return void
     */
    public function indexAction ()
    {
        $this->setView('clube', 'index')->render();
    }

    /**
     * @return void
     */
    public function searchAction ()
    {
        $this->setView('clube', 'search')->render();
    }

    /**
     * @return void
     */
    public function listAction ()
    {
        $this->setView('clube', 'list')->render();
    }

    /**
     * @return void
     */
    public function loadGridSearchAction ()
    {
        $query = 'clube c inner join pais p on p.id_pais = c.id_pais';

        $grid = \br\com\cf\library\core\grid\Grid::factory()
                ->primary('id_clube')
                ->columns(array(
                    0 => array('c.id_clube' => 'id_clube'),
                    1 => array('c.nm_clube' => 'nm_clube'),
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