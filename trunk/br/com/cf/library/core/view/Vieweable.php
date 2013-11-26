<?php

namespace br\com\cf\library\core\view;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
interface Vieweable
{

    public function set ($var, $value, $nocache = true);

    public function render ();
}