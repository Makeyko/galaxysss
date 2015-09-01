<?php

/**
 * BaseForm
 *
 * При создании нового класса путем наследования в класе должна быть указана константа TABLE,
 * указывающая какую таблицу будет обрабатывать форма
 *
 * Предназначен для опертивного создания формы
 *
 * Описание всех полей находится в public static $fields;
 *
 * Автоматически генерируются правила валидации
 *
 * Функция update обрабатывает POST и проходит по всем onUpdate в виджетах
 *
 * Есть две функции getFormFieldId() и getFormFieldName()
 *
 * Автоматический вывод всех полей формы в представление
 *
 * Есть функция getTableName()
 *
 * Insert
 * если есть только onUpdate то вызывается после вставки
 * там где есть onInsert
 *
 * Update
 *
 *
 */


namespace cs\base;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use yii\db\Query;
use yii\jui\DatePicker;
use cs\Widget\FileUpload\FileUpload;
use cs\Widget\RadioList\RadioList;
use cs\Widget\Place\Place;

class BaseForm extends Model
{
    protected $row;

    public static $fields = [];

    const POS_DB_NAME     = 0;
    const POS_RUS_NAME    = 1;
    const POS_IS_REQUIRED = 2;
    const POS_RULE        = 3;
    const POS_PARAMS      = 4;
    const POS_HINT        = 5;

    /**
     * Возвращает идентификатор поля в форме, например `orderlombard-name`
     *
     * @param string $name название поля
     *
     * @return string
     */
    public function getFormFieldId($name)
    {
        return strtolower($this->formName() . '-' . $name);
    }

    /**
     * Возвращает название поля в форме, например `OrderLombard[name]`
     *
     * @param string $name название поля
     *
     * @return string
     */
    public function getFormFieldName($name)
    {
        return $this->formName() . '[' . $name . ']';
    }

    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param \yii\bootstrap\ActiveForm $form
     * @param string                    $name
     *
     * @return \yii\bootstrap\ActiveField
     */
    public function field($form, $name)
    {
        $fieldObject = $form->field($this, $name);
        $fieldArray = $this->findField($name);
        $label = ArrayHelper::getValue($fieldArray, self::POS_RUS_NAME, '');
        if ($label != '') {
            $fieldObject->label($label);
        }
        $hint = ArrayHelper::getValue($fieldArray, self::POS_HINT, '');
        if ($hint != '') {
            $fieldObject->hint($hint);
        }
        $widget = ArrayHelper::getValue($fieldArray, 'widget', '');
        if ($widget != '') {
            $fieldObject->widget($widget[0], ArrayHelper::getValue($widget, 1, []));
        }

        return $fieldObject;
    }

    public static function rulesAdd($fields = null)
    {
        if (is_null($fields)) {
            $fields = static::$fields;
        }
        $ret = [];
        $required = [];
        foreach ($fields as $field) {
            if ($field[ self::POS_IS_REQUIRED ] == 1) {
                $required[] = $field[0];
            }
        }
        $ret[] = [
            $required,
            'required',
            'message' => 'Поле должно быть заполнено обязательно'
        ];
        foreach ($fields as $field) {
            if (isset($field[ self::POS_RULE ])) {
                $item = [
                    [$field[ self::POS_DB_NAME ]],
                    $field[ self::POS_RULE ]
                ];
                if (isset($field[ self::POS_PARAMS ])) {
                    if (count($field[ self::POS_PARAMS ]) > 0) {
                        foreach ($field[ self::POS_PARAMS ] as $key => $value) $item[ $key ] = $value;
                    }
                }
                $ret[] = $item;
            }
        }

        return $ret;
    }

    public function __construct($config = [])
    {
        \yii\validators\Validator::$builtInValidators['date'] = 'cs\validators\DateValidator';
        $this->initDate(static::$fields);
        parent::__construct($config);
    }

    public function load($post, $formName = null)
    {
        if (!parent::load($post, $formName)) return false;
        foreach (static::$fields as $field) {
            $class = ArrayHelper::getValue($field, 'widget.0', '');
            if ($class != '') {
                if (method_exists($class, 'onLoad')) {
                    $class::onLoad($field, $this);
                }
            }
        }

        if (isset(static::$fields2)) {
            foreach (self::$fields as $field) {
                $class = ArrayHelper::getValue($field, 'widget.0', '');
                if ($class != '') {
                    if (method_exists($class, 'onLoad')) {
                        $class::onLoad($field, $this);
                    }
                }
            }
        }

        return true;
    }

    protected function onLoad($fields)
    {
        foreach ($fields as $field) {

        }
    }

    /**
     * Возвращает описание поля из массива self::$fields
     *
     * @param string $name - имя поля базы данных
     *
     * @return array|null
     */
    public static function findField($name)
    {
        foreach (static::$fields as $field) {
            if ($field[ self::POS_DB_NAME ] == $name) return $field;
        }

        return null;
    }

    /**
     * Ищет запись в таблице
     *
     * @return static
     */
    public static function find($id)
    {
        $table = static::TABLE;
        $query = new Query();
        $row = $query->select('*')->from($table)->where(['id' => $id])->one();
        if ($row) {
            $item = new static($row);
            $item->row = $row;

            foreach ($item::$fields as $field) {
                $class = ArrayHelper::getValue($field, 'widget.0', '');
                if ($class != '') {
                    if (method_exists($class, 'onLoadDb')) {
                        $class::onLoadDb($field, $item);
                    }
                }
            }

            return $item;
        }
        else {
            return null;
        }
    }

    /**
     * @param \yii\widgets\ActiveForm $form
     */
    public function echoFieldList($form, $fields = null)
    {
        /** @var \yii\widgets\ActiveField $object */
        $model = $this;
        if (is_null($fields)) {
            $fields = static::$fields;
        }
        foreach ($fields as $field) {
            if (isset($field['draw'])) {
                $method = $field['draw'];
                $object = call_user_func($method, $form, $this, $field);
            }
            else {
                $object = $form->field($model, $field[0])->label($field[1]);

                if (isset($field[ self::POS_HINT ])) {
                    if ($field[ self::POS_HINT ] != '') {
                        $object->hint($field[ self::POS_HINT ]);
                    }
                }
                if (isset($field['widget'])) {
                    $class = $field['widget'][0];
                    $object->widget($class::className(), ArrayHelper::getValue($field, 'widget.1', []));
                }
                if (isset($field[ self::POS_RULE ])) {
                    if ($field[ self::POS_RULE ] != '') {
                        if ($field[ self::POS_RULE ] == 'file') {
                            $object->widget(FileUpload::className());
                        }
                    }
                }
                if (isset($field[ self::POS_RULE ])) {
                    if ($field[ self::POS_RULE ] != '') {
                        if ($field[ self::POS_RULE ] == 'boolean') $object->checkbox();
                    }
                }
                if (isset($field[ self::POS_RULE ])) {
                    if ($field[ self::POS_RULE ] != '') {
                        if ($field[ self::POS_RULE ] == 'date') $object->widget(DatePicker::classname(), [
                            'dateFormat' => 'php:d.m.Y',
                            'options'    => [
                                'class' => 'form-control',
                            ],
                        ]);
                    }
                }
                if (ArrayHelper::keyExists('type', $field)) {
                    $options = [];
                    if (is_array($field['type'])) {
                        $name = $field['type'][0];
                        if ((isset($field['type'][1]))) {
                            $options = $field['type'][1];
                        }
                    }
                    else {
                        $name = $field['type'];
                    }
                    switch ($name) {
                        case 'checkbox':
                            $object->checkbox();
                            break;
                        case 'textarea':
                            $object->textarea($options);
                            break;
                        case 'listBox':
                            $object->listBox($options);
                            break;
                        case 'RadioList':
                            $object->widget(\cs\Widget\RadioList\RadioList::className(), $options);
                            break;
                        case 'CheckBox':
                            $object->widget(\cs\Widget\CheckBox\CheckBox::className(), $options);
                            break;
                        case 'radioList':
                            $object->radioList($options);
                            break;
                        case 'place':
                            $object->widget(Place::className(), $options);
                            break;
                        case 'hidden':
                            $options['id'] = strtolower($this->formName()) . '-' . $field[ self::POS_DB_NAME ];
                            $object = Html::hiddenInput($this->formName() . '[' . $field[ self::POS_DB_NAME ] . ']', null, $options);
                            break;
                        case 'autoComplete':
                            $options['clientOptions']['select'] = new JsExpression("function( event, ui ) {" . "$('#" . strtolower($model->formName()) . "-" . $field[ self::POS_DB_NAME ] . "').val(ui.item.id);" . "}");
                            $attr = $object->attribute;
                            if ($model->$attr != '') {
                                echo Html::hiddenInput($model->formName() . '[' . $field[ self::POS_DB_NAME ] . ']', $model->$attr, ['id' => strtolower($model->formName()) . '-' . $field[ self::POS_DB_NAME ]]);
                            }
                            else {
                                echo Html::hiddenInput($model->formName() . '[' . $field[ self::POS_DB_NAME ] . ']', $model->$attr, ['id' => strtolower($model->formName()) . '-' . $field[ self::POS_DB_NAME ]]);
                            }
                            $object->attribute = $field[ self::POS_DB_NAME ] . '_name';
                            $object->widget(\yii\jui\AutoComplete::classname(), $options);
                            break;

                    }
                }
            }
            echo $object;
        }

    }

    protected function initDate($fields)
    {
        foreach ($fields as $field) {
            if (isset($field[ BaseForm::POS_RULE ])) {
                if ($field[ BaseForm::POS_RULE ] == 'date') {

                    $fieldName = $field[ BaseForm::POS_DB_NAME ];
                    $format = ArrayHelper::getValue($field, BaseForm::POS_PARAMS . '.format', '');

                    if ($format != '') {
                        if (StringHelper::startsWith($format, 'php:')) {
                            $format = substr($format, 4);
                            if (!is_null($this->$fieldName)) {
                                if ($this->$fieldName != '') {
                                    $date = new \DateTime($this->$fieldName, new \DateTimeZone('UTC'));
                                    $value = $date->format($format);
                                    $this->$fieldName = $value;
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    protected function updateGetValue($value, $field)
    {
        $name = $field[ self::POS_DB_NAME ];
        if (isset($field[ self::POS_RULE ])) {
            if ($field[ self::POS_RULE ] != '') {
                if ($field[ self::POS_RULE ] == 'file') {
                    return FileUpload::onUpdate($value, $field, $this);
                }
            }
        }
        if (isset($field[ self::POS_RULE ])) {
            if ($field[ self::POS_RULE ] != '') {
                if ($field[ self::POS_RULE ] == 'date') {
                    $format = ArrayHelper::getValue($field, BaseForm::POS_PARAMS . '.format', '');
                    if ($format != '') {
                        if (StringHelper::startsWith($format, 'php:')) {
                            $format = substr($format, 4);
                            if (!is_null($this->$name)) {
                                if ($this->$name != '') {
                                    $date = \DateTime::createFromFormat($format, $this->$name, new \DateTimeZone('UTC'));

                                    return $date->format('Y-m-d');
                                }
                            }
                        }
                    }

                    return '';
                }
            }
        }
        if (isset($field['onUpdate'])) {
            $methodName = $field['onUpdate'];

            return $this->$methodName($this->$name, $field);
        }

        return $this->$name;
    }

    protected function insertGetValue($value, $field)
    {
        $name = $field[ self::POS_DB_NAME ];
        if (isset($field[ self::POS_RULE ])) {
            if ($field[ self::POS_RULE ] != '') {
                if ($field[ self::POS_RULE ] == 'file') {
                    return FileUpload::onInsert($value, $field, $this);
                }
            }
        }
        if (isset($field[ self::POS_RULE ])) {
            if ($field[ self::POS_RULE ] != '') {
                if ($field[ self::POS_RULE ] == 'date') {
                    $format = ArrayHelper::getValue($field, BaseForm::POS_PARAMS . '.format', '');
                    if ($format != '') {
                        if (StringHelper::startsWith($format, 'php:')) {
                            $format = substr($format, 4);
                            if (!is_null($this->$name)) {
                                if ($this->$name != '') {
                                    $date = \DateTime::createFromFormat($format, $this->$name, new \DateTimeZone('UTC'));

                                    return $date->format('Y-m-d');
                                }
                            }
                        }
                    }

                    return '';
                }
            }
        }

        return $this->$name;
    }

    protected static function getType($field)
    {
        if (!isset($field['type'])) {
            return '';
        }
        if ($field['type'] == '') {
            return '';
        }
        if (is_string($field['type'])) {
            return $field['type'];
        }
        if (is_array($field['type'])) {
            return $field['type'][0];
        }

        return '';
    }

    protected function processUpdateField(&$dbFields, $field)
    {
        $name = $field[0];
        if (isset($field['widget'])) {
            $class = $field['widget'][0];
            if (method_exists($class, 'onUpdate')) {
                $new = $class::onUpdate($field, $this);
                foreach ($new as $k => $v) {
                    $dbFields[ $k ] = $v;
                }
            }
            else {
                $value = $this->$name;
                $value = $this->updateGetValue($value, $field);

                $dbFields[ $name ] = $value;
            }

            return;
        }
        if (self::getType($field) == 'place') {
            $new = Place::onUpdate($field, $this);
            foreach ($new as $k => $v) {
                $dbFields[ $k ] = $v;
            }

            return;
        }
        if (self::getType($field) == 'RadioList') {
            $new = RadioList::onUpdate($field, $this);
            foreach ($new as $k => $v) {
                $dbFields[ $k ] = $v;
            }

            return;
        }
        $value = $this->$name;
        $value = $this->updateGetValue($value, $field);

        $dbFields[ $name ] = $value;
    }

    // если есть метод onInsert и onUpdate то при инсерте нужно выбрать onInsert
    protected function processInsertField(&$dbFields, $field)
    {
        $name = $field[0];
        if (isset($field['widget'])) {
            $class = $field['widget'][0];
            if (method_exists($class, 'onInsert')) {
                $new = $class::onInsert($field, $this);
                foreach ($new as $k => $v) {
                    $dbFields[ $k ] = $v;
                }
            }

            return;
        }
        if (self::getType($field) == 'place') {
            $new = Place::onUpdate($field, $this);
            foreach ($new as $k => $v) {
                $dbFields[ $k ] = $v;
            }

            return;
        }
        if (self::getType($field) == 'RadioList') {
            $new = RadioList::onUpdate($field, $this);
            foreach ($new as $k => $v) {
                $dbFields[ $k ] = $v;
            }

            return;
        }
        $value = $this->$name;
        $value = $this->updateGetValue($value, $field);

        $dbFields[ $name ] = $value;
    }

    /**
     * Возвращает список полей для добавления в таблицу или обновления
     *
     * @param array $fieldsCols массив полей-описаний
     *
     * @return array список полей таблицы БД
     */
    public function getFieldsFromFormInsert($fieldsCols = null)
    {
        if (is_null($fieldsCols)) {
            $fieldsCols = static::$fields;
        }
        $fields = [];
        foreach ($fieldsCols as $field) {
            $this->processInsertField($fields, $field);
        }

        return $fields;
    }

    /**
     * Возвращает список полей для добавления в таблицу или обновления
     *
     * @param array $fieldsCols массив полей-описаний
     *
     * @return array список полей таблицы БД
     */
    public function getFieldsFromFormUpdate($fieldsCols = null)
    {
        if (is_null($fieldsCols)) {
            $fieldsCols = static::$fields;
        }
        $fields = [];
        foreach ($fieldsCols as $field) {
            $this->processUpdateField($fields, $field);
        }

        return $fields;
    }

    /**
     * Обновляет запись в таблицу
     *
     * @return boolean | array поля или false если небыло пройдена валидация формы
     */
    public function update($fieldsCols = null)
    {
        if (!$this->validate()) {
            return false;
        }

        $beforeUpdate = null;
        if (is_null($fieldsCols)) {
            $fieldsCols = static::$fields;
        }
        else {
            if (isset($fieldsCols['beforeUpdate'])) {
                $beforeUpdate = $fieldsCols['beforeUpdate'];
                $fieldsCols = static::$fields;
            }
        }
        $fields = $this->getFieldsFromFormUpdate($fieldsCols);
        if (!is_null($beforeUpdate)) {
            $fields = call_user_func($beforeUpdate, $fields);
        }
        (new Query())->createCommand()->update(static::TABLE, $fields, ['id' => $this->id])->execute();

        return $fields;
    }

    /**
     * Вставляет поля в таблицу
     *
     * @param null|array $fieldsCols
     *
     * @return array
     */
    public function insert($fieldsCols = null)
    {
        if (!$this->validate()) {
            return false;
        }
        $beforeInsert = null;
        $beforeUpdate = null;

        if (is_null($fieldsCols)) {
            $fieldsCols = static::$fields;
        }
        else {
            if (isset($fieldsCols['beforeInsert'])) {
                $beforeInsert = $fieldsCols['beforeInsert'];
            }
            if (isset($fieldsCols['beforeUpdate'])) {
                $beforeUpdate = $fieldsCols['beforeUpdate'];
            }
            $fieldsCols = static::$fields;
        }
        $fields = $this->getFieldsFromFormInsert($fieldsCols);
        if (!is_null($beforeInsert)) {
            $fields = call_user_func($beforeInsert, $fields);
        }
        (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();
        $fields['id'] = \Yii::$app->db->getLastInsertID();
        $this->id = $fields['id'];

        // ищу file
        $fieldsUpdate = [];
        foreach ($fieldsCols as $field) {
            $widget = ArrayHelper::getValue($field, 'widget.0', '');
            if ($widget != '') {
                if (!method_exists($widget, 'onInsert')) {
                    $ret = $widget::onUpdate($field, $this);
                    foreach ($ret as $k => $v) {
                        $fieldsUpdate[ $k ] = $v;
                    }
                }
            }
        }
        if (!is_null($beforeUpdate)) {
            $fieldsUpdate = call_user_func($beforeUpdate, $fieldsUpdate);
        }
        if (count($fieldsUpdate) > 0) {
            (new Query())->createCommand()->update(static::TABLE, $fieldsUpdate, ['id' => $fields['id']])->execute();
        }

        return ArrayHelper::merge($fieldsUpdate, $fields);
    }

    /**
     * Вставляет или обновляет поля в таблицу
     * Если есть строка то update
     * Если нет - то insert
     *
     * @param null|array $fieldsCols
     * @param null|array $condition запос на выборку
     * @param null|array $params    параметры для запроса
     *
     * @return array
     */
    public function insertOne($fieldsCols = null, $condition = [], $params = [])
    {
        $fields = $this->getFieldsFromFormInsert($fieldsCols);

        $count = (new Query())->select('*')->from(static::TABLE)->where($condition, $params)->count();
        if ($count == 0) {
            (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();
            $fields['id'] = \Yii::$app->db->getLastInsertID();
        }
        else {
            (new Query())->createCommand()->update(static::TABLE, $fields, $condition, $params)->execute();
        }

        return $fields;
    }

    public function rules()
    {
        return $this->rulesAdd();
    }

    public function fieldsAutoCompleteOnLoad($value, $field, $options)
    {
        return [
            'id'   => $value,
            'name' => ArrayHelper::getValue($options, 'sql.one')->sqalar(),
        ];
    }

    public function getTableName()
    {
        return static::TABLE;
    }

    public function drawDetailView()
    {
        $html[] = '<table class="table table-striped table-bordered detail-view">';
        $html[] = '<tbody>';

        foreach (static::$fields as $field) {
            $html[] = '<tr>';
            $html[] = '<td>';
            $html[] = $field[ self::POS_RUS_NAME ];
            $html[] = '</td>';
            $html[] = '<td>';
            $html[] = $this->drawDetailView_processField($field);
            $html[] = '</td>';
            $html[] = '</tr>';
            continue;
        }
        $html[] = '</tbody>';
        $html[] = '</table>';

        echo join('', $html);
    }

    private function drawDetailView_processField($field)
    {
        if (ArrayHelper::keyExists('widget', $field)) {
            $className = ArrayHelper::getValue($field, 'widget.0', '');
            if ($className != '') {
                if (method_exists($className, 'onDraw')) {
                    return $className::onDraw($field, $this);
                }
            }
        }
        if (isset($field['drawDetailView'])) {
            $method = $field['drawDetailView'];

            return call_user_func($method, $this, $field);
        }
        if (ArrayHelper::keyExists('type', $field)) {
            $options = [];
            if (is_array($field['type'])) {
                $name = $field['type'][0];
                if ((isset($field['type'][1]))) {
                    $options = $field['type'][1];
                }
            }
            else {
                $name = $field['type'];
            }
            $fieldName = $field[ self::POS_DB_NAME ];
            switch ($name) {
                case 'place':
                    return \cs\models\Place::initFromModel($this, $fieldName);
                case 'radioList':
                    $value = $this->$fieldName;

                    return $options[ $value ];
                case 'file':
                    return \cs\Widget\FileUpload2\FileUpload::drawDetailView($this, $field);
                case 'checkbox':
                    $value = $this->$fieldName;
                    if (is_null($value)) return '';
                    if ($value == 0) return 'Нет';
                    if ($value == 1) return 'Да';
            }
        }

        if (isset($field[ self::POS_RULE ])) {
            if ($field[ self::POS_RULE ] != '') {
                $dbName = $field[ self::POS_DB_NAME ];
                switch ($field[ self::POS_RULE ]) {
                    case 'string':
                        return $this->$dbName;
                    case 'url':
                        return Html::a($this->$dbName, $this->$dbName);
                    case 'integer':
                        return $this->$dbName;
                    case 'date':
                        return $this->$dbName;
                }
            }
        }
    }

    /**
     * Удаляет запись из таблицы и вызывает статический метод onDelete для всех виджетов
     *
     * @return bool
     */
    public function delete()
    {
        if (is_null($this->id)) return true;

        foreach (static::$fields as $field) {
            $widget = ArrayHelper::getValue($field, 'widget.0', '');
            if ($widget != '') {
                if (method_exists($widget, 'onDelete')) {
                    $widget::onDelete($field, $this);
                }
            }
        }
        (new Query())->createCommand()->delete(static::TABLE, ['id' => $this->id])->execute();

        return true;
    }

    /**
     * Возвращает идентификатор
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}