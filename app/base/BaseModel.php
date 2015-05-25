<?php

namespace cs\base;

use yii\db\Query;

class BaseModel
{
    protected $fields;

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->fields['id'];
    }

    public static function responseSuccess($data = '')
    {
        if ($data == '') {
            return [
                'status' => true,
            ];
        } else {
            return [
                'status' => true,
                'data'   => $data,
            ];
        }
    }

    public static function responseError($data)
    {
        return [
            'status' => false,
            'data'   => $data,
        ];
    }

    /**
     * Обновляет текущаю таблицу
     *
     * @param array $fields набор полей
     *
     * @return int количество затронутых строк
     */
    public function update($fields)
    {
        return (new Query())->createCommand()->update(static::TABLE, $fields, ['id' => $this->getId()])->execute();
    }

    /**
     * Добавляет пользователя
     *
     * @param array $fields поля
     *
     * @return static|null
     */
    public static function insert($fields)
    {
        (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();
        $fields['id'] = \Yii::$app->db->getLastInsertID();

        return new static($fields);
    }

    /**
     * Ищет пользователя по идентификатору
     *
     * @param integer $id идентификатор пользователя
     *
     * @return static
     */
    public static function find($id)
    {
        $query = new Query();
        $row = $query->select('*')->from(static::TABLE)->where(['id' => $id])->one();
        if (!$row) {
            return null;
        } else {
            return new static($row);
        }
    }
}