<?php


namespace cs\base;


use yii\db\Query;
use yii\helpers\VarDumper;

class DbRecord
{
    protected $fields;

    public function __construct($fields)
    {
        $this->fields = $fields;
    }

    public function getId()
    {
        return $this->fields['id'];
    }

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
            $condition = $id;
            $row = self::query($condition)->one();
            if ($row === false) $row = null;
        } else {
            $row = self::_find($id);
        }
        if (is_null($row)) return null;

        return new static($row);
    }

    /**
     * Возвращает заготовку Query для создания запросов
     *
     * @param $condition
     * @param $params
     *
     * @return Query
     */
    public static function query($condition = null, $params = null)
    {
        $query = (new Query())->select('*')->from(static::TABLE);
        if (!is_null($condition)) {
            $query->where($condition, $params);
        }

        return $query;
    }

    /**
     * Ищет строку по идентификатору
     *
     * @param integer $id идентификатор пользователя
     *
     * @return array|null
     */
    protected static function _find($id)
    {
        $row = (new Query())->select('*')->from(static::TABLE)->where(['id' => $id])->one();
        if ($row === false) return null;

        return $row;
    }

    /**
     * Обновляет запись таблицы
     *
     * @return bool
     * true - Если была обновлена запись
     * false - Запись не была обновлена, например если все поля соответствуют переданным
     */
    public function update($fields)
    {
        return ((new Query())->createCommand()->update(static::TABLE, $fields, ['id' => $this->getId()])->execute() > 0);
    }

    /**
     * Возвращает значение поля
     * Если оно не найдено среди полей то будет возвращено null
     *
     * @param string|int $name    индекс массива для $this->fields
     * @param mixed      $default значение по умолчанию если нет индекса
     *
     * @return null|mixed
     */
    public function getField($name, $default = null)
    {
        if (array_key_exists($name, $this->fields)) {
            return $this->fields[ $name ];
        }

        return $default;
    }

    /**
     * Возвращает значение поля
     * Если оно не найдено среди полей то будет возвращено ''
     * Если значение поля равно null то будет возвращено ''
     *
     * @param $name
     *
     * @return int|string
     */
    public function get($name)
    {
        $value = $this->getField($name);

        return (is_null($value)) ? '' : $value;
    }

    /**
     * Удаляет запись таблицы
     *
     * @return bool
     */
    public function delete()
    {
        return ((new Query())->createCommand()->delete(static::TABLE, ['id' => $this->getId()])->execute() > 0);
    }

    public static function deleteByCondition($condition = null, $params = [])
    {
        return ((new Query())->createCommand()->delete(static::TABLE, $condition, $params)->execute() > 0);
    }

    /**
     * @param string|array $fields
     * @param string|array $condition
     * @param array        $params
     *
     * @return array
     */
    public static function search($fields, $condition, $params = [])
    {
        return (new Query())->select($fields)->from(static::TABLE)->where($condition, $params)->all();
    }

    public static function insert($fields)
    {
        (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();
        $id = \Yii::$app->db->getLastInsertID();
        $fields['id'] = $id;

        return new static($fields);
    }

    public static function batchInsert($columns, $rows)
    {
        (new Query())->createCommand()->batchInsert(static::TABLE,$columns, $rows)->execute();
    }

    /**
     * Сохраняет параметры $set в таблицу,
     * если они уже есть ($where) то обновляются данные (update)
     * если их нет - то добавляются данные (insert)
     *
     * @param $set
     * @param $where
     *
     * @throws \yii\db\Exception
     */
    public function save($set, $where)
    {
        if ((new Query())->select('*')->from(static::TABLE)->where($where)->exists()) {
            (new Query())->createCommand()->update(static::TABLE, $set, $where)->execute();
        }
        else {
            foreach ($set as $k => $v) {
                $where[ $k ] = $v;
            }
            (new Query())->createCommand()->insert(static::TABLE, $where)->execute();
        }
    }

    /**
     * Добавляет запись в таблицу если ее нет
     *
     * @param $fields
     *
     * @return static
     *
     */
    public static function insertOne($fields)
    {
        $row = (new Query())->select('id')->from(static::TABLE)->where($fields)->one();
        if ($row !== false) {
            return new static($row);
        }

        return self::insert($fields);
    }

    public function getFields()
    {
        return $this->fields;
    }

    public static function getTableName()
    {
        return static::TABLE;
    }
} 