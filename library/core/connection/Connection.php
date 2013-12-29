<?php

namespace br\com\cf\library\core\connection;

use br\com\cf\library\core\config\Config,
    br\com\cf\Bootstrap

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 * @version 0.0.0
 */
class Connection
{

    /**
     * @var Connection
     */
    public static $instance = NULL;

    /**
     * @var \PDO
     */
    private $_connection = array();

    /**
     * @var string
     */
    private $_entry = NULL;

    /**
     * @return void
     */
    private function __construct ($entry = 'default')
    {
        try {

            $cfg = Config::factory();

            $database = $cfg->getParam("database.{$entry}.database");
            $host = $cfg->getParam("database.{$entry}.host");
            $user = $cfg->getParam("database.{$entry}.user");
            $password = $cfg->getParam("database.{$entry}.password");
            $driver = $cfg->getParam("database.{$entry}.driver");

            $this->_connection[$entry] = new \PDO(sprintf("%s:host=%s;dbname=%s", $driver, $host, $database), $user, $password, Bootstrap::factory()->getPDOExtraParams());

            $this->_connection[$entry]->setAttribute(
                    \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
            );

            if ($driver == 'mysql') {
                $this->_connection[$entry]->exec("SET NAMES 'utf8'");
                $this->_connection[$entry]->exec('SET character_set_connection=utf8');
                $this->_connection[$entry]->exec('SET character_set_client=utf8');
                $this->_connection[$entry]->exec('SET character_set_results=utf8');
            }

            $this->_entry = $entry;
        } catch (\PDOException $e) {
            $this->_connection[$entry] = NULL;
            throw new \Exception($e);
        }
    }

    /**
     * @return \PDO
     * @param string $entry
     */
    public static function factory ($entry)
    {

        if (self::$instance instanceof Connection) {
            return self::$instance;
        }

        return self::$instance = new self($entry);
    }

    /**
     * @return \PDO
     */
    public function getConnection ()
    {
        return $this->_connection[$this->_entry];
    }

    /**
     * @return void
     */
    public function __destruct ()
    {
        $this->_connection[$this->_entry] = NULL;
    }

}
