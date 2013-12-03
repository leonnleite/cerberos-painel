<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\model\ModelPais

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerPais extends ControllerAbstract {

    /**
     * @return void
     */
    public function autocompleteAction() {
        $this->json(ModelPais::factory()->autocomplete($this->getParam('term')));
    }

}