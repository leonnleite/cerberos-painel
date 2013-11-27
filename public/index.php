<?php

/**
 * BenchMark - Begin
 */
$usec = $sec = null;
list($usec, $sec) = explode(' ', microtime());
$begin = (float) $sec + (float) $usec;

/**
 * BasePath
 */
define('CF_APP_BASE_PATH', realpath(__DIR__ . '/../../../../'));

/**
 * Constant Environment
 */
defined('APPLICATION_ENV')
        || define('CF_APP_ENVIRONMENT', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

/**
 * AutoLoaderClass
 */
include (CF_APP_BASE_PATH . '/br/com/cf/library/autoload/Loader.php');

/**
 * 
 */
use br\com\cf\Bootstrap,
    br\com\cf\library\core\session\Session,
    br\com\cf\app\controller\ControllerError,
    br\com\cf\library\core\exception\ExceptionAcl

;

try {

    /**
     * Loader
     */
    $loader = new Loader();

    /**
     * Set Include Path
     */
    $loader->setIncludePath(CF_APP_BASE_PATH)
            ->setIncludePath(CF_APP_BASE_PATH . '/br/com/cf/library/respect')
            ->setFileExtension('.php')
            ->register();

    /**
     * Session Start
     */
    Session::start('cf');

    /**
     * BootStrap
     */
    Bootstrap::factory()->dispatch();
} catch (ExceptionAcl $e) {
    /**
     * ControllerError
     */
    ControllerError::factory()->setView('error', 'denied')->set('error', $e->getMessage())->render();
} catch (\Exception $e) {
    if (CF_APP_ENVIRONMENT == 'development') {
        ControllerError::factory()->setView('error', 'error')->set('error', $e->getMessage())->set('file', $e->getFile())->set('line', $e->getLine())->render();
    } else {
        //$controllerError = ControllerError::factory();
        print sprintf('<fieldset class="alert alert-error"><h5>Erro:</h5>%s<h5>Arquivo:</h5>%s<h5>Linha:</h5>%s</fieldset>', $e->getMessage(), $e->getFile(), $e->getLine());
    }
}

/**
 * BenchMark - Final
 */
list($usec, $sec) = explode(' ', microtime());
$final = (float) $sec + (float) $usec;
$total = round($final - $begin, 5);

if (!Bootstrap::factory()->isAjax()) {
    echo '<div id="score-time" class="label"><i></i>tempo aproximado gasto: <strong>', $total, '</strong> segundos. memoria utilizada: <strong>', round(((memory_get_peak_usage(true) / 1024) / 1024), 2), 'Mb</strong></div>';
}

// Exibimos uma mensagem
