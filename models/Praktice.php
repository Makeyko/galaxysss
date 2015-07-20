<?php

namespace app\models;

use cs\services\BitMask;
use yii\db\Query;

class Praktice extends \cs\base\SiteContent
{
    const TABLE = 'gs_praktice';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    /**
     * @return \yii\db\Query
     */
    public static function queryList()
    {
        return self::query()->select([
            'id',
            'header',
            'image',
            'source',
            'date_insert',
            'date',
            'view_counter',
            'description',
            'id_string',
        ]);
    }
}