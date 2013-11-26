<?php

namespace br\com\cf\library\core\uploader;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Uploader
{

    /**
     * @var string
     */
    private $_token;

    /**
     * @var integer
     */
    private $_count = 0;

    /**
     * @var array
     */
    private $_paths = array();

    /**
     * @return void
     */
    private function __construct ()
    {
        
    }

    /**
     * @return Uploader
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * @return string
     */
    public function setToken ($token)
    {
        return $this->_token = $token;
    }

    /**
     * @return integer
     */
    public function getCount ()
    {
        return $this->_count;
    }

    /**
     * @return integer
     */
    public function getPaths ()
    {
        return $this->_paths;
    }

    /**
     * @return Uploader
     */
    public function register ($request = array())
    {
        /**
         * Cria o diretorio temporario de uploads...
         */
        if (!is_dir(CF_APP_UPLOADER_PATH)) {
            mkdir(CF_APP_UPLOADER_PATH, 0777, true);
        }

        /**
         * Cria o sub-diretorio temporario dos uploads...
         */
        if (!mkdir(CF_APP_UPLOADER_PATH . '/' . $this->_token)) {
            throw new \Exception('Não foi possível criar o repositório temporário!');
        }


        /**
         * Envia e manter os arquivos no diretorio temporario...
         */
        foreach ($request as $label => $current) {

            foreach ($current['name'] as $key => $file) {
                if (is_uploaded_file($request[$label]['tmp_name'][$key])) {
                    if (!move_uploaded_file($request[$label]['tmp_name'][$key], CF_APP_UPLOADER_PATH . '/' . $this->_token . '/' . $request[$label]['name'][$key])) {
                        throw new \Exception('Ocorreu um erro ao tentar efetuar o envio do arquivo!');
                    }
                    $this->_count++;
                    $this->_paths[$this->_count]['name'] = $request[$label]['name'][$key];
                    $this->_paths[$this->_count]['size'] = $request[$label]['size'][$key];
                }
            }
        }

        return $this;
    }

    /**
     * @return Uploader
     */
    public function copy ($files = array())
    {
        foreach ($files as $key => $file) {
            copy(CF_APP_UPLOADER_PATH . '/' . $this->_token . '/' . $file[0], $file[1]);
        }

        return $this;
    }

    /**
     * @return Uploader
     */
    public function move ($files = array())
    {
        foreach ($files as $key => $file) {
            rename(CF_APP_UPLOADER_PATH . '/' . $this->_token . '/' . $file[0], $file[1]);
        }

        return $this;
    }

    /**
     * @return Uploader
     */
    public function clean ()
    {

        $dir = CF_APP_UPLOADER_PATH . '/' . $this->_token;

        if (!is_dir($dir)) {
            throw new Exception('Este diretório não existe!');
        }

        if ($handle = opendir($dir)) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    if (is_file($dir . '/' . $file)) {
                        unlink($dir . '/' . $file);
                    }
                }
            }
        }

        return $this;
    }

}