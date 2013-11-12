<?php

namespace br\com\cf\app\controller;

use br\com\cf\library\core\controller\ControllerAbstract;

/**
 * @autor Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ControllerDownloads extends ControllerAbstract
{

    /**
     * @return void
     */
    public function premiumAction ()
    {
        $this->setView('downloads', 'premium')->render();
    }

    /**
     * @return void
     */
    public function downloadAction ()
    {
        header('Location: ' . sprintf('http://contaspremium.net/cp/SistemaDownload/?link=%s&lk=%s\n', $this->getParam('id'), md5(microtime())));
    }

}