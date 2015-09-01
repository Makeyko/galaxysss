<?php
/**
 * UserCache
 *
 * Занимается кешированием данных пользователя
 * Имя ключа = 'user/{id}'
 *
 * При обновлении данных пользователя [[update()]] кеш сбрасывается
 */

namespace app\models;

use yii\helpers\VarDumper;

trait UserCache
{
    /**
     * Ищет строку по идентификатору
     *
     * @param integer|array $id идентификатор пользователя
     *
     * @return static
     */
    public static function find($id)
    {
        if (is_array($id)) {
            return parent::find($id);
        }

        $keyName = 'user/'.$id;
        $user = \Yii::$app->session->get($keyName, false);
//        \cs\services\VarDumper::dump($_SESSION);
        if ($user === false) {
            $user = parent::_find($id);
            \Yii::$app->session->set($keyName,$user);
        }

        return new static($user);

    }

    /**
     * Обновляет поля в базе, в $this->fields, сбрасывает кеш
     * @param $fields
     *
     * @return bool
     */
    public function update($fields)
    {
        $keyName = 'user/'.$this->getId();
        \Yii::$app->session->remove($keyName);

        foreach($fields as $k => $v) {
            $this->fields[$k] = $v;
        }
        parent::update($fields);

        return true;
    }

    public function cacheClear()
    {
        $keyName = 'user/'.$this->getId();
        \Yii::$app->session->remove($keyName);
    }
}