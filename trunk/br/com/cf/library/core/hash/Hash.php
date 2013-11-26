<?php

namespace br\com\cf\library\core\hash;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Hash
{

    /**
     * @return void
     */
    private function __construct ()
    {
        
    }

    /**
     * @return string
     * @param string $string
     * @param string $delimiter
     */
    public static function strToHex ($string, $delimiter = '-')
    {
        $max = strlen($string);

        for ($i = 0; $i < $max; $i++) {
            $n_str[] = base_convert(ord($string[$i]), 10, 16);
        }
        return implode($delimiter, $n_str);
    }

    /**
     * @return string
     * @param string $str
     * @param string $delimiter
     */
    public static function hexToStr ($str, $delimiter = '-')
    {
        $string = '';
        $str = explode($delimiter, $str);
        $max = count($str);
        for ($i = 0; $i < $max; $i++) {
            $string .= chr(hexdec($str[$i]));
        }
        return $string;
    }

    /**
     * @return string
     * @param string $data
     * @param string $key
     */
    public static function encrypt ($data, $key)
    {
        return self::strToHex(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    /**
     * @return string
     * @param string $crypttext
     * @param string $key
     */
    public static function decrypt ($crypttext, $key)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, self::hexToStr($crypttext), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

}