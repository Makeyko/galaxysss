<?php

namespace cs\Widget\CheckBoxTreeMask;

use yii\db\Query;
use yii\filters\AccessControl;

class Controller extends \cs\base\BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                            /** @var \app\models\User $user */
                            $user = \Yii::$app->user->identity;
                            return $user->isAdmin();
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * Добавляет элемент после указанного
     *
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

        return self::jsonSuccess([
            'id' => $newId
        ]);
    }

    /**
     * Добавляет элемент в указанный как дочерний
     *
     * REQUEST:
     * id - int - идентификатор записи
     * text - string - наименование новой записи
     * tableName - string - название таблицы
     */
    public function actionAdd_into()
    {
        $tableName = self::getParam('tableName');
        $text = self::getParam('text');
        $id = self::getParam('id');

        // сортировка
        {
            $ids = (new Query())
                ->select('id')
                ->from($tableName)
                ->where(['parent_id' => $id])
                ->orderBy(['sort_index' => SORT_ASC])
                ->column();
        }
        (new Query())->createCommand()->insert($tableName, [
            'name'      => $text,
            'parent_id' => $id
        ])->execute();
        $newId = \Yii::$app->db->getLastInsertID();
        // сортировка
        {
            // собираю список id
            $new = [$newId];
            foreach ($ids as $id2) {
                $new[] = $id2;
            }
            // обновляю sort_index
            $c = 0;
            foreach($new as $i) {
                (new Query())->createCommand()->update($tableName, ['sort_index' => $c], ['id' => $i])->execute();
                $c++;
            }
        }

        return self::jsonSuccess([
            'id' => $newId
        ]);
    }

    /**
     * Удаляет строку
     *
     * REQUEST:
     * id - int - идентификатор записи
     * tableName - string - название таблицы
     */
    public function actionDelete()
    {
        $tableName = self::getParam('tableName');
        $id = self::getParam('id');
        $this->delete($tableName, $id);

        return self::jsonSuccess();
    }

    /**
     * Удаляет элемент и все вложенные
     * Вызывает саму себя (рекурсивный цикл)
     *
     * @param string $tableName
     * @param integer $id
     *
     * @throws \yii\db\Exception
     */
    private function delete($tableName, $id)
    {
        $parent_ids = (new Query())->select('id')->from($tableName)->where(['parent_id' => $id])->column();
        foreach($parent_ids as $pid) {
            $this->delete($tableName, $pid);
        }
        (new Query())->createCommand()->delete($tableName, ['id' => $id])->execute();
    }
}