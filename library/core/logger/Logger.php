<?php

namespace br\com\cf\library\core\logger;

use br\com\cf\library\core\logger\Loggeble,
    br\com\cf\library\klogger\KLogger

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Logger implements Loggeble
{

    /**
     * @var KLogger
     */
    private $_logger;

    /**
     * @return void
     */
    private function __construct ($priority)
    {
        $this->_logger = new KLogger(CF_APP_LOG_FILE, $priority);
        $this->_logger->DateFormat = 'Y-m-d H:i:s';
    }

    /**
     * @return AdapterPhtml
     */
    public static function factory ($priority = 2/* INFO */)
    {
        return new self($priority);
    }

    /**
     * @return Loggeble
     * @param integer $line
     * @param integer $priority
     */
    public function Log ($line, $priority)
    {
        $this->_logger->Log($line, $priority);
        return $this->_logger;
    }

    /**
     * @return Loggeble
     * @param integer $line
     */
    public function LogDebug ($line)
    {
        $this->_logger->LogDebug($line);
        return $this->_logger;
    }

    /**
     * @return Loggeble
     * @param integer $line
     */
    public function LogError ($line)
    {
        $this->_logger->LogError($line);
        return $this->_logger;
    }

    /**
     * @return Loggeble
     * @param integer $line
     */
    public function LogFatal ($line)
    {
        $this->_logger->LogFatal($line);
        return $this->_logger;
    }

    /**
     * @return Loggeble
     * @param integer $line
     */
    public function LogInfo ($line)
    {
        $this->_logger->LogInfo($line);
        return $this->_logger;
    }

    /**
     * @return Loggeble
     * @param integer $line
     */
    public function LogWarn ($line)
    {
        $this->_logger->LogWarn($line);
        return $this->_logger;
    }

}