<?php

namespace br\com\cf\library\core\grid;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 * @version 0.0.0.
 */
interface Grideable
{

    /**
     * @return void
     * @param GridAbstract $grid
     * @param string $filter
     */
    public function filtering (GridAbstract $grid, $filter);

    /**
     * @return void
     * @param GridAbstract $grid
     * @param string $filter
     */
    public function individualFiltering (GridAbstract $grid, $filter);

    /**
     * @return void
     * @param GridAbstract $grid
     */
    public function result (GridAbstract $grid);

    /**
     * @return void
     * @param GridAbstract $grid
     */
    public function totalRecords (GridAbstract $grid);

    /**
     * @return void
     * @param GridAbstract $grid
     */
    public function totalDisplayRecords (GridAbstract $grid);
}