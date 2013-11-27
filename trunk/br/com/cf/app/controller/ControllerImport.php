<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract,
    br\com\cf\app\business\BusinessImport

;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerImport extends ControllerAbstract {

    /**
     * @return void
     */
    public function indexAction() {


        BusinessImport::factory()->generateInsertsCountries();

//        throw new Exception('Ocorreu um erro!');
//        set_time_limit(0);
//
//        $result = BusinessImport::factory()->updatePhotosSelections();
//
//        var_dump($result);
//        if (!Auth::isAuthenticated()) {
//            $this->forward('Usuario', 'formAuth');
//        }
//
//        $this->setView('index', 'index')
//                ->set('background', '/img/wallpaper.jpg')
//                ->set('nm_usuario', Session::get('user')->nm_usuario)
//                ->render();
    }

}