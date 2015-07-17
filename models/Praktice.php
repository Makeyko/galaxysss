<?php

namespace app\models;

use cs\services\BitMask;
use yii\db\Query;

class Article extends \cs\base\SiteContent
{
    const TABLE = 'gs_praktice';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }
}