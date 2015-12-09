<?php

namespace app\models\Shop;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;
use yii\helpers\Url;

class RequestProduct extends \cs\base\DbRecord
{
    const TABLE = 'gs_users_shop_requests_products';

}