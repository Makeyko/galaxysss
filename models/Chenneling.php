<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 05.05.2015
 * Time: 23:41
 */

namespace app\models;


class Chenneling extends \cs\base\DbRecord
{
    const TABLE = 'gs_cheneling_list';

    const MEMCACHE_KEY_LIST = '\app\controllers\PageController::actionChenneling';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    public static function clearCache()
    {
        \Yii::$app->cache->delete(self::MEMCACHE_KEY_LIST);
    }
}