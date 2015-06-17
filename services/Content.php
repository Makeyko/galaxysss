<?php

namespace app\services;


use cs\services\Str;
use yii\helpers\Html;
use yii\helpers\VarDumper;

class Content
{
    public static $formatIcon = [
        370,
        370,
        \cs\Widget\FileUpload2\FileUpload::MODE_THUMBNAIL_CUT
    ];

    /**
     * Добавляет ссылки в текст
     * Если в тексте есть ссылка http|https то она будет обернута в <a href="">
     */
    public static function parseLink($content)
    {
        $pattern = '/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i';

        $strings = explode("\n", $content);

        $retStrings = [];
        foreach ($strings as $string) {
            if (trim($string) != '') {
                $words = explode(' ', $string);
                $retWords = [];
                foreach ($words as $word) {
                    if (filter_var($word, FILTER_VALIDATE_REGEXP, [
                            'options' => ['regexp' => $pattern]
                        ]) !== false
                    ) {
                        $value = Html::a($word, $word, ['target' => '_blank']);
                    }
                    else {
                        $value = $word;
                    }
                    $retWords[] = $value;
                }
                $retStrings[] = join(' ', $retWords);
            }
            else {
                $retStrings[] = $string;
            }
        }

        return join("\n", $retStrings);
    }

    /**
     * Преобразовывает текст в HTML
     * Если в передаваемом параметре есть уже HTML то он не будет обработан
     *
     * @param string $content
     *
     * @return string
     */
    public static function convertPlainTextToHtml($content)
    {
        if (Str::pos('<', $content) === false) {
            $rows = explode("\r", $content);
            $rows2 = [];
            foreach ($rows as $row) {
                if (trim($row) != '') $rows2[] = Html::tag('p', trim($row));
            }

            return join("\r\r", $rows2);
        }

        return $content;
    }
} 