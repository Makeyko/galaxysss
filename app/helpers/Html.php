<?php

namespace cs\helpers;


use yii\helpers\ArrayHelper;

class Html extends \yii\helpers\Html
{
    /**
     * Возвращает массив ['style' => 'name: value; name: value;', ...]
     *
     * @param array $options
     * @param array $styleOptions
     *
     * @return array
     */
    public static function css($styleOptions = [], &$options = null)
    {
        if (is_null($options)) $options = [];
        Html::addCssStyle($options, $styleOptions);

        return $options;
    }
} 