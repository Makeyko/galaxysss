<?php

namespace app\models;

use app\services\Subscribe;
use cs\services\BitMask;
use cs\services\VarDumper;
use yii\base\Object;
use yii\db\Query;

class Zvezdnoe extends Object
{
    public $data;

    public static function set($json)
    {
        $data = json_decode($json);
        $class = new self($data);

        return $class;
    }

    public function __toString()
    {
        return json_encode([
            'data' => $this->data,
        ]);
    }
}