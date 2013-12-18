<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerCopa extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {
        $this->setView('copa', 'index')->render();
    }

    /**
     * @return void
     */
    public function formCreateAction() {
        $this->setView('copa', 'formCreate')->render();
    }

    /**
     * @return void
     */
    public function gamesAdminAction() {
        $this->setView('copa', 'games')->render();
    }

    /**
     * @return void
     */
    public function listAction() {
        $this->setView('copa', 'list')->render();
    }

    /**
     * @return void
     */
    public function artilleryAction() {
        $this->setView('copa', 'artillery')->render();
    }

    /**
     * @return void
     */
    public function groupsAction() {
        $this->setView('copa', 'groups')->render();
    }

    /**
     * @return void
     */
    public function finalsAction() {
        $this->setView('copa', 'finals')->render();
    }

    /**
     * @return void
     */
    public function gamesAction() {
        $this->setView('copa', 'games')->render();
    }

}