<?php

/**
 * Базовый класс для хранения настроек полей таблицы
 * Содержит главную функцию ::get($fields)
 * где $fields это массив названий полей db_name
 *
 */
namespace cs\base;


class BaseTable
{
    /**
     * Возвращает список полей
     * Если $fields == null то возвращается весь список полей
     *
     * @param null|array $fields
     *
     * @return array
     */
    public static function get($fields = null)
    {
        if (is_null($fields)) {
            return static::getFields();
        }
        $ret = [];
        foreach ($fields as $fieldName) {
            $ret[] = self::findField($fieldName);
        }

        return $ret;
    }

    /**
     * Возвращает описание поля из массива self::$fields
     *
     * @param string $name - имя поля базы данных
     *
     * @return array|null
     */
    protected static function findField($name)
    {
        foreach (static::getFields() as $field) {
            if ($field[ \cs\base\BaseForm::POS_DB_NAME ] == $name) return $field;
        }

        return null;
    }

    /**
     * Возвращает описание поля из массива self::$fields
     *
     * @param array  $fields - массив описаний полей
     * @param string $name   - имя поля базы данных
     *
     * @return array|null
     */
    public static function find($fields, $name)
    {
        foreach ($fields as $field) {
            if ($field[ \cs\base\BaseForm::POS_DB_NAME ] == $name) return $field;
        }

        return null;
    }
}