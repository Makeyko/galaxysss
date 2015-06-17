<?php


namespace app\models;


use cs\services\VarDumper;

class Union extends \cs\base\DbRecord
{
    const TABLE = 'gs_unions';
    const PREFIX_CACHE_OFFICE_LIST = '\app\controllers\PageController::actionFood_item::';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    /**
     * @param array | string $select поля для выборки
     * @return array
     */
    public function getOfficeList($select = null)
    {
        $key = self::PREFIX_CACHE_OFFICE_LIST.$this->getId();
        $rows = \Yii::$app->cache->get($key);
        if ($rows === false) {
            $query = UnionOffice::query(['union_id' => $this->getId()]);
            if (is_null($select)) {
                $select = [
                    'point_lat as lat',
                    'point_lng as lng',
                    'concat("<h5>",point_address,"</h5>") as html',
                ];
            }
            $rows = $query->select($select)->all();
            \Yii::$app->cache->set($key, $rows);
        }

        return $rows;
    }

    /**
     * @param int $id идентификатор объединения
     */
    public static function deleteCacheOfficeList($id)
    {
        \Yii::$app->cache->delete(self::PREFIX_CACHE_OFFICE_LIST . $id);
    }

    /**
     * Одобряет объединение
     */
    public function accept()
    {
        $this->update(['moderation_status' => 1]);
    }

    /**
     * Отклоняет объединение
     */
    public function reject()
    {
        $this->update(['moderation_status' => 0]);
    }

    public function getUserId()
    {
        return $this->getField('user_id');
    }

    /**
     * @return \app\models\User
     */
    public function getUser()
    {
        return User::find($this->getUserId());
    }
}