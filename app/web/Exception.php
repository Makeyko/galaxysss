<?php

namespace cs\web;

class Exception extends \yii\base\UserException
{
    public function getName()
    {
        return 'Ошибка';
    }
} 