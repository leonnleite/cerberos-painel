<?php

namespace br\com\cf\library\core\cache;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Cache
{

    /**
     * @var string
     */
    private $_output;

    /**
     * @return void
     */
    private function __construct ()
    {
        
    }

    /**
     * @return Cache 
     */
    public static function factory ()
    {
        return new self();
    }

    /**
     * @return void
     */
    private function generateCacheContentsJsStatics ($files, $cache)
    {

        $content = $full = '';

        foreach ($files as $value) {
            if ($value[1] == true) {
                $content .= file_get_contents(CF_APP_PUBLIC_PATH . '/' . current($value));
            } else {
                $full .= file_get_contents(CF_APP_PUBLIC_PATH . '/' . current($value));
            }
        }

        require_once (CF_APP_LIBRARY_PATH . '/jsmin/JSMin.php');
        file_put_contents($cache, \JSMin::minify($content) . $full);
    }

    /**
     * @return void
     */
    public static function generateCacheContentsCssStatics ($files, $cache)
    {

        $content = '';
        $full = '';

        foreach ($files as $value) {
            if ($value[1] == true) {
                $content .= file_get_contents(CF_APP_PUBLIC_PATH . '/' . current($value));
            } else {
                $full .= file_get_contents(CF_APP_PUBLIC_PATH . '/' . current($value));
            }
        }

        require_once (CF_APP_LIBRARY_PATH . '/cssmin/CSSMin.php');
        file_put_contents($cache, \CssMin::minify($content) . $full);
    }

    /**
     * @return boolean
     */
    public static function renovateCacheContentStatics ($files, $cache)
    {
        foreach ($files as $value) {
            if (filemtime(CF_APP_PUBLIC_PATH . '/' . current($value)) > @filemtime($cache)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return void
     */
    public function js ($minifierJs)
    {

        $hash = '';

        foreach ($minifierJs as $value) {
            $hash .= current($value) . $value[1];
        }

        $file = CF_APP_CACHE_PATH . '/' . md5($hash) . '.js';

        if (self::renovateCacheContentStatics($minifierJs, $file)) {
            self::generateCacheContentsJsStatics($minifierJs, $file);
        }

        $this->_output .= "<script type='text/javascript' src='/cache/" . md5($hash) . '.js?' . filemtime($file) . "'></script>\n";

        return $this;
    }

    /**
     * @return void
     */
    public function css ($minifierCss)
    {

        $hash = '';

        foreach ($minifierCss as $value) {
            $hash .= current($value) . $value[1];
        }

        $file = CF_APP_CACHE_PATH . '/' . md5($hash) . '.css';

        /**
         * Verificar se eh necessario renovar o cache...
         */
        if (self::renovateCacheContentStatics($minifierCss, $file)) {
            self::generateCacheContentsCssStatics($minifierCss, $file);
        }

        $this->_output .= "<link href='/cache/" . md5($hash) . '.css?' . filemtime($file) . "' rel='stylesheet' type='text/css'>\n";

        return $this;
    }

    /**
     * @return Cache
     */
    public function output ()
    {
        echo $this->_output;
        return $this;
    }

    /**
     * @return Cache
     */
    public function clean ()
    {
        unset($this->_output);
        return $this;
    }

}