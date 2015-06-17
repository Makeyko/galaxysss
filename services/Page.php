<?php

namespace app\services;


use yii\helpers\Html;

class Page
{
    public static function linkToSite($url)
    {
        return Html::tag('p', Html::a('Перейти на сайт »', $url, [
            'class'  => 'btn btn-primary',
            'role'   => 'button',
            'target' => '_blank',
        ]));
    }
} 