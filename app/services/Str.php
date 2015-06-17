<?php

namespace cs\services;

use yii\helpers\ArrayHelper;

class Str
{
    public static $encoding = 'utf-8';

    public static function length($string)
    {
        return mb_strlen($string, self::$encoding);
    }

    public static function sub($string, $start, $length = null)
    {
        return mb_substr($string, $start, $length, self::$encoding);
    }

    public static function pos($find, $content)
    {
        return mb_strpos($content, $find, null, self::$encoding);
    }

    /**
     * Превращает строку в camelCase style
     *
     * @param $string
     *
     * @return string
     */
    public static function camelCase($string)
    {
        return strtoupper(substr($string, 0, 1)) . substr($string, 1);
    }


    public static function getChars($string)
    {
        $len = self::length($string);
        $ret = [];
        for ($i = 0; $i < $len; $i++) {
            $ret[ $i ] = self::sub($string, $i, 1);
        }

        return $ret;
    }

    public static function rus2translit($string)
    {
        $maxLength = 30;
        $converter = [
            'а' => 'a', 'б' => 'b', 'в' => 'v',
            'г' => 'g', 'д' => 'd', 'е' => 'e',
            'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
            'и' => 'i', 'й' => 'y', 'к' => 'k',
            'л' => 'l', 'м' => 'm', 'н' => 'n',
            'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u',
            'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
            'ь' => '', 'ы' => 'y', 'ъ' => '',
            'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

            'A' => 'a', 'B' => 'b', 'C' => 'c',
            'D' => 'd', 'E' => 'e', 'F' => 'f',
            'G' => 'g', 'H' => 'h', 'I' => 'i',
            'J' => 'j', 'K' => 'k', 'L' => 'l',
            'M' => 'm', 'N' => 'n', 'O' => 'o',
            'P' => 'p', 'Q' => 'q', 'R' => 'r',
            'S' => 's', 'T' => 't', 'U' => 'u',
            'V' => 'v', 'W' => 'w', 'X' => 'x',
            'Y' => 'y', 'Z' => 'z',

            'a' => 'a', 'b' => 'b', 'c' => 'c',
            'd' => 'd', 'e' => 'e', 'f' => 'f',
            'g' => 'g', 'h' => 'h', 'i' => 'i',
            'j' => 'j', 'k' => 'k', 'l' => 'l',
            'm' => 'm', 'n' => 'n', 'o' => 'o',
            'p' => 'p', 'q' => 'q', 'r' => 'r',
            's' => 's', 't' => 't', 'u' => 'u',
            'v' => 'v', 'w' => 'w', 'x' => 'x',
            'y' => 'y', 'z' => 'z',

            'А' => 'a', 'Б' => 'b', 'В' => 'v',
            'Г' => 'g', 'Д' => 'd', 'Е' => 'e',
            'Ё' => 'e', 'Ж' => 'zh', 'З' => 'z',
            'И' => 'i', 'Й' => 'y', 'К' => 'k',
            'Л' => 'l', 'М' => 'm', 'Н' => 'n',
            'О' => 'o', 'П' => 'p', 'Р' => 'r',
            'С' => 's', 'Т' => 't', 'У' => 'u',
            'Ф' => 'f', 'Х' => 'h', 'Ц' => 'c',
            'Ч' => 'ch', 'Ш' => 'sh', 'Щ' => 'sch',
            'Ь' => '', 'Ы' => 'y', 'Ъ' => '',
            'Э' => 'e', 'Ю' => 'yu', 'Я' => 'ya',
            ' ' => '_',
        ];
        $ret = '';
        foreach (self::getChars($string) as $char) {
            $ret .= ArrayHelper::getValue($converter, $char, '');
        }
        $ret = substr($ret,0,$maxLength);

        return $ret;
    }

    /**
     * Возвращает ответ на вопрос
     * Есть ли строка $find в $source?
     *
     * @param $source
     * @param $find
     *
     * @return int
     */
    public static function isContain($source, $find)
    {
        return mb_strpos($source, $find) !== false;
    }
}