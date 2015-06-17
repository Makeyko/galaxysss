<?php
/**
 * Created by PhpStorm.
 * User: prog3
 * Date: 08.05.15
 * Time: 13:38
 */

namespace app\modules\Comment;

use yii;

class Service
{


    public static function render($typeId, $rowId)
    {
        return Yii::$app->view->render('@app/modules/Comment/views/comments', [
            'type_id' => $typeId,
            'row_id'  => $rowId,
        ]);
    }
} 