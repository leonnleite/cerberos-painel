<?php

namespace br\com\cf\library\core\email;

use br\com\cf\Bootstrap;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Email
{

    /**
     * @var Email
     */
    private static $instance;

    /**
     * @var \PHPMailer
     */
    private $_email;

    /**
     * @return void
     */
    private function __construct ()
    {

        include(CF_APP_LIBRARY_PATH . "/phpmailer/class.phpmailer.php");

        /**
         * PHPMailer
         */
        $phpmailer = new \PHPMailer();

        /**
         * Config
         */
        $config = Bootstrap::factory()->getConfig();

        /**
         * Configuration
         */
        $phpmailer->SMTPDebug = $config->getParam('email.defaultDebug');
        $phpmailer->SMTPAuth = $config->getParam('email.defaultAuth');
        $phpmailer->Host = $config->getParam('email.defaultHost');
        $phpmailer->Port = $config->getParam('email.defaultPort');
        $phpmailer->Username = $config->getParam('email.defaultUser');
        $phpmailer->Password = $config->getParam('email.defaultPassword');
        $phpmailer->SetLanguage("br", CF_APP_LIBRARY_PATH . '/phpmailer/language/phpmailer.lang-br.php');

        $this->_email = $phpmailer;
    }

    /**
     * @return Email
     */
    protected static function singleton ()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @return Email
     */
    public static function factory ()
    {
        return self::singleton();
    }

    /**
     * @return Email
     * @param string $email
     * @param string $name
     */
    public function from ($email, $name)
    {
        $this->_email->SetFrom($email, $name);
        return $this;
    }

    /**
     * @return Email
     */
    public function isSMTP ()
    {
        $this->_email->IsSMTP();
        return $this;
    }

    /**
     * @return Email
     */
    public function isHTML ()
    {
        $this->_email->IsHTML();
        return $this;
    }

    /**
     * @return Email
     * @param string $email
     * @param string $name
     */
    public function addAddress ($email, $name)
    {
        $this->_email->AddAddress($email, $name);
        return $this;
    }

    /**
     * @return Email
     * @param string $email
     * @param string $name
     */
    public function addCopy ($email, $name)
    {
        $this->_email->AddReplyTo($email, $name);
        return $this;
    }

    /**
     * @return Email
     * @param string $subject
     */
    public function subject ($subject)
    {
        $this->_email->Subject = $subject;
        $this->_email->AltBody = $subject;
        return $this;
    }

    /**
     * @return Email
     * @param string $message
     */
    public function message ($message)
    {
        $this->_email->MsgHTML($message);
        return $this;
    }

    /**
     * @return Email
     * @param string $file
     * @param string $name
     */
    public function addAttachment ($file, $name = '')
    {
        $this->_email->AddAttachment($file, $name);
        return $this;
    }

    /**
     * @return Email
     */
    public function send ()
    {
        $this->_email->Send();
        return $this;
    }

}