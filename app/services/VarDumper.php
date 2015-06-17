<?php

namespace cs\services;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class VarDumper
{
    public static function dump($value, $depth = 10, $highlight = true)
    {
        Yii::$app->response->charset = 'utf-8';
        Yii::$app->response->send();

        \yii\helpers\VarDumper::dump($value, $depth, $highlight);
        $c = 1;

        echo "\r\n";
        echo '<pre>';
        foreach (debug_backtrace(2) as $item) {
            echo '#' . $c . ' ' . ArrayHelper::getValue($item, 'file', '') . ':' . ArrayHelper::getValue($item, 'line', '') . ' ' . ArrayHelper::getValue($item, 'class', '') . ArrayHelper::getValue($item, 'type', '') . ArrayHelper::getValue($item, 'function', '') . "\n";
            $c++;
        }
        echo '</pre>';
        exit;
    }
} 