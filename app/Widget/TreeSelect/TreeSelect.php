<?php

namespace cs\Widget\TreeSelect;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use cs\base\BaseForm;
use yii\jui\InputWidget;

/**
 * Класс TreeSelect
 *
 * Виджет который выдает список SELECT в виде дерева
 *


$field->widget('cs\Widget\TreeSelect\TreeSelect', [

]);

*/

class TreeSelect extends InputWidget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'form-control'];

    public $tableName;
    public $rootId;

    private $fieldId;
    private $fieldName;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->fieldId = strtolower($this->model->formName() . '-' . $this->attribute);
        $this->fieldName = $this->model->formName() . '[' . $this->attribute . ']';
    }

    /**
     * рисует виджет
     */
    public function run()
    {
        $this->registerClientScript();
        $attribute = $this->attribute;

        return Html::dropDownList($this->fieldName, $this->model->$attribute, $this->getItems(), $this->options);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
    }

    /**
     * Возвращает элементы списка
     * @return array
     * [[
     *  'id' => 'name'
     * ], ... ]
     */
    public function getItems()
    {
        $rows = $this->getRows($this->rootId);

        return $this->convertTreeToFlat($rows);
    }

    /**
     * Возвращает элементы списка
     * @return array
     * [[
     *  'id' =>
     *  'name' =>
     *  'nodes' => array
     * ], ... ]
     */
    public function getRows($parentId)
    {
        $rows = (new Query())->select('id,header as name')->from($this->tableName)->where(['parent_id' => $parentId])->all();
        for($i = 0; $i < count($rows); $i++ ) {
            $item = &$rows[$i];
            $rows2 = $this->getRows($item['id']);
            if (count($rows2) > 0) {
                $item['nodes'] = $rows2;
            }
        }

        return $rows;
    }

    /**
     * @param array $rows
     * @return array
     */
    private function convertTreeToFlat($rows)
    {
        $ret = [];
        foreach($rows as $item) {
            $ret[$item['id']] = $item['name'];
            if (ArrayHelper::keyExists('nodes', $item)) {
                $rows2 = $this->convertTreeToFlat($item['nodes']);
                foreach($rows2 as $k => $v) {
                    $ret[$k] = '---' . $v;
                }
            }
        }

        return $ret;
    }

    /**
     * Возвращает опции для виджета
     *
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [
        ];
    }

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return array поля для обновления в БД
     */
    public static function onUpdate($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        return [
            $fieldName => $model->$fieldName,
        ];
    }
}
