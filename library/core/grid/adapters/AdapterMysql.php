<?php

namespace br\com\cf\library\core\grid\adapters;

use br\com\cf\library\core\grid\GridAbstract,
    br\com\cf\library\core\grid\Grideable

;

/**
 *
 * @author Michael F. Rodrigues
 * @version 0.0.0
 */
class AdapterMysql extends \br\com\cf\library\core\model\ModelAbstract implements Grideable {

    /**
     * @var string
     */
    protected $_primary = '';

    /**
     * @var string
     */
    protected $_table = '';

    /**
     * return void
     * @param GridAbstract $grid
     * @param string $filter
     */
    public function individualFiltering(GridAbstract $grid, $filter = 'or') {

        $params = $grid->getParams();
        $condition = explode(',', $params['sColumns']);

        for ($i = 0; $i < count($grid->getColumns()); $i++) {
            if (isset($params['bSearchable_' . $i]) && $params['bSearchable_' . $i] == "true" && $params['sSearch_' . $i] != '') {

                $where = $grid->getWhere();

                if ($condition[$i] == 'equals') {
                    $where .= sprintf("%s = '%s' {$filter} ", $grid->getColumns($i), $params['sSearch_' . $i]);
                }

                if ($condition[$i] == 'like') {
                    $where .= sprintf("%s %s '%s%s%s' {$filter} ", $grid->getColumns($i), $condition[$i], '%', $params['sSearch_' . $i], '%');
                }

                $grid->setWhere($where);
            }
        }
        $grid->setWhere(substr_replace($grid->getWhere(), '', -4));
    }

    /**
     * return void
     * @param GridAbstract $grid
     * @param string $filter
     */
    public function filtering(GridAbstract $grid, $filter = 'or') {
        if ($grid->getParams('sSearch') != '') {
            for ($i = 0; $i < count($grid->getColumns()); $i++) {
                if ($grid->getParam('bSearchable_' . $i) == 'true') {
                    $where = $grid->getWhere();
                    $where .= sprintf("%s like '%s%s%s' {$filter} ", $grid->getColumns($i), '%', $grid->getParam('sSearch'), '%');
                    $grid->setWhere($where);
                }
            }
            $grid->setWhere(substr_replace($grid->getWhere(), '', -3));
        }
    }

    /**
     * return void
     * @param GridAbstract $grid
     */
    public function result(GridAbstract $grid) {

        $implode = '';
        $columns = $grid->getColumns();

        foreach ($columns as $column) {
            foreach ($column as $real => $alias) {
                $implode .= " {$real} as {$alias}, ";
            }
        }

        $sQuery = sprintf('select %s from %s %s %s %s %s', substr($implode, -0, -2), $grid->getQuery(), $grid->getWhere(), $grid->getGroup(), $grid->getOrder(), $grid->getLimit());

        $stmt = $this->_conn->prepare($sQuery);
        $stmt->execute();

        $grid->setResult($stmt->fetchAll(\PDO::FETCH_OBJ));
    }

    /**
     * return void
     * @param GridAbstract $grid
     */
    public function totalRecords(GridAbstract $grid) {
        $sQuery = sprintf('select count(*) as total from %s ', $grid->getQuery());
        $stmt = $this->_conn->prepare($sQuery);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_OBJ);

        $total = 0;

        if (!empty($result)) {
            $total = $result->total;
        }

        $grid->setTotal($total);
    }

    /**
     * return void
     * @param GridAbstract $grid
     */
    public function totalDisplayRecords(GridAbstract $grid) {
        if ($grid->getWhere() != '') {

            $sQuery = sprintf('select count(*) as total from %s %s limit 1', $grid->getQuery(), $grid->getWhere());

            $stmt = $this->_conn->prepare($sQuery);
            $stmt->execute();

            $result = $stmt->fetch(\PDO::FETCH_OBJ);

            $total = 0;

            if (!empty($result)) {
                $total = $result->total;
            }

            $grid->setFilteredTotal($total);
        } else {
            $grid->setFilteredTotal($grid->getTotal());
        }
    }

    /**
     * @return void
     * @param GridAbstract $grid
     */
    public function paging(GridAbstract $grid) {
        if ($grid->getParam('iDisplayStart') != '' && $grid->getParam('iDisplayLength') != '-1') {
            $grid->setLimit(sprintf('limit %d,%d', $grid->getParam('iDisplayStart'), $grid->getParam('iDisplayLength') + $grid->getParam('iDisplayStart')));
        }
    }

}