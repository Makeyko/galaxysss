<?php

namespace app\models;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;

class HD extends \cs\base\DbRecord
{
    const TABLE = 'gs_hd';
}