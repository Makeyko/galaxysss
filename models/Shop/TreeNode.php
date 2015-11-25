<?php

namespace app\models\Shop;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;

class TreeNode extends \cs\base\DbRecord
{
    const TABLE = 'gs_unions_shop_tree';
}