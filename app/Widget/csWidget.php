<?php
/**
 * Интерфейс для виджета
 */

namespace cs\Widget;


interface csWidget
{
    /**
     * Вызывается после find для загрузки данных из таблицы
     * в модели уже помещены данные строки в поле $model->row
     *
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onLoadDb($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onLoadPost($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onUpdate($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onInsert($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onDraw($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onView($field, $model);

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return mixed
     */
    public static function onDelete($field, $model);

    /**
     * Возвращает параметры валидатора или false если такового нет
     *
     * @return array|false ['name' => 'className']
     */
    public static function getValidator();
}