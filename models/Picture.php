<?php

namespace app\models;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;

class Article extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_pictures';


    /**
     * Выдает путь к картинке
     *
     * @param bool $isScheme добавлять хост?
     *
     * @return string
     */
    public function getFile($isScheme = false)
    {
        $url = $this->getField('file','');
        if ($url == '') return '';

        return \yii\helpers\Url::to($url, $isScheme);
    }
}