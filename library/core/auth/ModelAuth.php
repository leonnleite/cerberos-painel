<?php

namespace br\com\cf\library\core\auth;

use br\com\cf\library\core\model\ModelAbstract,
    br\com\cf\Bootstrap

;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class ModelAuth extends ModelAbstract
{

    /**
     * @var string
     */
    protected $_table = '';

    /**
     * @var string
     */
    protected $_primary = '';

    /**
     * @var array
     */
    protected $_fields = array();

    /**
     * @return stdClass
     */
    public function autheticate ($params)
    {
        try {

            $stmt = $this->_conn->prepare(Bootstrap::factory()->getConfig()->getParam('auth.query'));

            foreach ($params as $field => &$value) {
                $stmt->bindValue(":{$field}", $value);
            }

            $stmt->execute();

            return $stmt->fetch(\PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
    }

}