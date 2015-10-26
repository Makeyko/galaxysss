<?php

namespace app\models;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;

class Shop extends \cs\base\DbRecord
{
    const TABLE = 'gs_unions_shop';

    public function getName()
    {
        return $this->getField('name', '');
    }

    public function getAdminEmail()
    {
        return $this->getField('admin_email', '');
    }
}