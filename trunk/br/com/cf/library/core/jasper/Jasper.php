<?php

namespace br\com\cf\library\core\jasper;

use br\com\cf\Bootstrap;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Jasper
{

    /**
     * @var \PHPJasperXML
     */
    private $_jasper = NULL;

    /**
     * @return void
     */
    private function __construct ()
    {

        include (CF_APP_LIBRARY_PATH . '/phpjasperxml/class/tcpdf/tcpdf.php');
        include (CF_APP_LIBRARY_PATH . '/phpjasperxml/class/PHPJasperXML.inc.php');

        $this->_jasper = new \PHPJasperXML();
    }

    /**
     * @return Jasper
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     *  @return Jasper
     */
    public function debugSql ()
    {
        $this->_jasper->debugsql = true;
        return $this;
    }

    /**
     * @return Jasper
     */
    public function setParams ($params)
    {
        $this->_jasper->arrayParameter = $params;
        return $this;
    }

    /**
     * @return Jasper
     */
    public function beginDB ()
    {
        $cfg = Bootstrap::factory()->getConfig();
        $this->_jasper->transferDBtoArray($cfg->getParam('database.host'), $cfg->getParam('database.user'), $cfg->getParam('database.password'), $cfg->getParam('database.database'), $cfg->getParam('database.driver'));
        return $this;
    }

    /**
     * @return Jasper
     */
    public function setJrXml ($jrxml)
    {
        $this->_jasper->xml_dismantle(simplexml_load_file($jrxml));
        return $this;
    }

    /**
     * @return void
     */
    public function output ($type = 'D')
    {
        $this->_jasper->outpage($type);
    }

}