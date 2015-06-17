<?php

namespace cs\Widget\CheckBoxTreeMask;

use Yii;
use yii\base\InvalidConfigException;
use yii\debug\models\search\Debug;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use yii\widgets\InputWidget;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use cs\base\BaseForm;
use cs\services\BitMask;
use yii\db\Query;

/**
 * Виджет для вывода списка chackbox'ов по шаблону
 * Данные сохраняет в БД в виде маски
 *
 *
 * - tableName таблица
 *
 * - templateFile шаблон для виджета
 * - templateVariables - array - параметры передаваемые в шаблон
 */
class CheckBoxTreeMask extends InputWidget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    public $templateFile      = '@csRoot/Widget/CheckBoxTreeMask/template';
    public $templateVariables = [];

    private $attrId;
    private $attrName;

    public $tableName;
    public $rootId;
    /**
     * @var array, string
     *           поля для выборки, нужно вернуть поля id и name
     */
    public $select = 'id, name';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->attrId = strtolower($this->model->formName() . '-' . $this->attribute);
        $this->attrName = $this->model->formName() . '[' . $this->attribute . ']';
    }

    /**
     * Рисует виджет
     */
    public function run()
    {
        $this->registerClientScript();
        $rows = $this->getRows($this->rootId);
        $this->setAttributeSelected($rows);

        return $this->render($this->templateFile, [
            'rows'              => $rows,
            'formName'          => $this->model->formName(),
            'model'             => $this->model,
            'attrId'            => $this->attrId,
            'attrName'          => $this->attrName,
            'templateVariables' => $this->templateVariables,
        ]);
    }

    /**
     * Выставляет аттрибут selected в массиве $this->rows согласно $this->model->$attr
     */
    public function setAttributeSelected(&$rows)
    {
        $attr = $this->attribute;
        if (is_array($this->model->$attr)) {
            if (count($this->model->$attr) > 0) {
                for ($i = 0; $i < count($rows); $i++) {
                    $item = &$rows[ $i ];
                    $item['selected'] = in_array($item['id'], $this->model->$attr);
                    if (isset($item['nodes'])) {
                        $this->setAttributeSelected($item['nodes']);
                    }
                }
            }
        }
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {

    }

    /**
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [];
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
        $rows = (new Query())->select($this->select)->from($this->tableName)->where(['parent_id' => $parentId])->all();
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
     * Берет значения из POST и возвраает знаяения для добавления в БД
     *
     * @param array           $field
     * @param \yii\base\Model $model
     *
     * @return array
     */
    public static function onUpdate($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $value = $model->$fieldName;
        if (is_null($value)) return [
            $fieldName => null
        ];

        return [
            $fieldName => (new BitMask($value))->getMask()
        ];
    }

    /**
     *
     *
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return array поля для обновления в БД
     */
    public static function onLoadDb($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $value = $model->getRow()[$fieldName];
        $model->$fieldName = (new BitMask($value))->getArray();
    }
}
