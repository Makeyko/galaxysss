<?php
/**
 * Created by PhpStorm.
 * User: prog3
 * Date: 24.04.15
 * Time: 12:59
 */

namespace cs\web;


class Exception extends \yii\base\UserException
{
    public function getName()
    {
        return 'Ошибка';
    }
} 