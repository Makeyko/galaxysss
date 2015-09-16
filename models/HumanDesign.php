<?php


namespace app\models;


use yii\base\Object;
use yii\helpers\Json;
use yii\helpers\Url;

class HumanDesign extends Object
{
    public $image;
    public $type;
    public $profile;
    public $definition;
    public $inner;
    public $strategy;
    public $theme;
    public $cross;

    /**
     * Возвращает путь к картинке
     *
     * @param bool $isSchema
     *
     * @return string
     *
     */
    public function getImage($isSchema = false)
    {
        $url = $this->image;
        if (is_null($url)) {
            $url = '';
        }
        if ($url == '') {
            return '';
        }

        return Url::to($url, $isSchema);
    }

    public function getJson()
    {
        return Json::encode($this);
    }
}