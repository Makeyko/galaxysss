<?php

namespace cs\Widget\CheckBoxTreeMask;


use yii\db\Query;

class Controller extends \cs\base\BaseController
{
    /**
     * REQUEST:
     * id - int - идентификатор записи
     * text - string - наименование новой записи
     * tableName - string - название таблицы
     */
    public function actionAdd()
    {
        $tableName = self::getParam('tableName');
        $text = self::getParam('text');
        $id = self::getParam('id');
        $parent_id = (new Query())->select('parent_id')->from($tableName)->where(['id' => $id])->scalar();
        if ($parent_id === false) $parent_id = null;

        // сортировка
        {
            $ids = (new Query())
                ->select('id')
                ->from($tableName)
                ->where(['parent_id' => $parent_id])
                ->orderBy(['sort_index' => SORT_ASC])
                ->column();
        }
        (new Query())->createCommand()->insert($tableName, [
            'name'      => $text,
            'parent_id' => $parent_id
        ])->execute();
        $newId = \Yii::$app->db->getLastInsertID();
        // сортировка
        {
            // собираю список id
            $new = [];
            foreach ($ids as $id2) {
                $new[] = $id2;
                if ($id2 == $id) {
                    $new[] = $newId;
                }
            }
            // обновляю sort_index
            $c = 0;
            foreach($new as $i) {
                (new Query())->createCommand()->update($tableName, ['sort_index' => $c], ['id' => $i])->execute();
                $c++;
            }

        }
        return self::jsonSuccess();
    }
} 