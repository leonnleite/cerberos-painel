<?php

namespace br\com\cf\library\core\utils;

/**
 * @author Michael F. Rodrigues <cerberosnash@gmail.com>
 */
class Utils
{

    /**
     * @return string
     * @param string $date1
     * @param string $date2
     * @param string $return Options ('years','months','days','hours','minuts','seconds')
     */
    public static function diffDates ($date1, $date2, $return = 'seconds')
    {

        if (!in_array($return, array('years', 'months', 'days', 'hours', 'minuts', 'seconds'))) {
            throw new \Exception('Tipo de retorno inválido!');
        }

# subtracao das datas...
        $diff = abs(strtotime($date2) - strtotime($date1));

# diferenca em anos...
        $years = floor($diff / (365 * 60 * 60 * 24));
# diferenca em anos...
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
# diferenca em anos...
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
# diferenca em anos...
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
# diferenca em anos...
        $minuts = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
# diferenca em anos...
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));

        return (string) ${$return};
    }

    /**
     * @return array
     * @param string $filename
     */
    public static function parseIniFile ($filename)
    {
        $array = parse_ini_file($filename, true);
        $returnArray = array();
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $x = explode(':', $key);
                if (!empty($x[1])) {
                    $x = array_reverse($x, true);
                    foreach ($x as $k => $v) {
                        $i = trim($x[0]);
                        $v = trim($v);
                        if (empty($returnArray[$i])) {
                            $returnArray[$i] = array();
                        }
                        if (isset($array[$v])) {
                            $returnArray[$i] = array_merge($returnArray[$i], $array[$v]);
                        }
                        if ($k === 0) {
                            $returnArray[$i] = array_merge($returnArray[$i], $array[$key]);
                        }
                    }
                } else {
                    $returnArray[$key] = $array[$key];
                }
            }
        } else {
            return false;
        }

        return $returnArray;
    }

    /**
     * @return string
     * @param date $date
     * @param string $format
     */
    public static function formatDate ($date, $format)
    {
        $target = new \DateTime($date);
        return $target->format($format);
    }

}