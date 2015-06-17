<?php

namespace app\modules\Comment;

class Model extends \cs\base\DbRecord
{
    const TABLE = 'gs_comments';

    const TYPE_CHENNELING = 1;
    const TYPE_NEWS       = 2;
    const TYPE_ARTICLE    = 3;

    public static function insert($fields)
    {
        $fields['date_insert'] = gmdate('YmdHis');

        return parent::insert($fields);
    }
}