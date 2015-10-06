<?php

namespace app\models;

use cs\services\BitMask;
use yii\db\Query;

class SubscribeHistory extends \cs\base\DbRecord
{
    const TABLE = 'gs_subscribe_history';

    public function setContent($data)
    {
        $this->fields['content'] = $data;
        $this->update(['content' => $data]);
    }

}