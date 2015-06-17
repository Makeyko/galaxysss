<?php

namespace cs\Widget\CheckBoxListMask;

use Yii;
use yii\base\InvalidConfigException;
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

/**
 * Виджет для вывода списка chackbox'ов по шаблону
 * Данные сохраняет в БД в виде маски
 *
 *
 * - rows строки для виджета
 * [[
 *  'id'   => int,
 *  'name' => str,
 * ], ...]
 *
 * - templateFile шаблон для виджета
 * - templateVariables - array - параметры передаваемые в шаблон
 * - callbackDrawRows - Closure - функция которая обрабатывает `rows`
 */
class CheckBoxListMask extends InputWidget
{
    /**
     * @var string the template for arranging the CAPTCHA image tag and the text input tag.
     * In this template, the token `{image}` will be replaced with the actual image tag,
     * while `{input}` will be replaced with the text input tag.
     */
    public $template = '{input}{label1}{label2}';
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [
        'div'    => ['class' => ''],
        'input'  => ['class' => ''],
        'label1' => ['class' => ''],
        'label2' => ['class' => ''],
    ];

    public $label             = '';
    public $templateFile      = '@csRoot/Widget/CheckBoxListMask/template';
    public $templateVariables = [];

    private $attrId;
    private $attrName;
    public  $rows;
    public  $callbackDrawRows;

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

        if (!is_null($this->callbackDrawRows)) {
            $callback = $this->callbackDrawRows;

            return call_user_func($callback, $this->rows);
        }
        $this->setAttributeSelected();

        return $this->render($this->templateFile, [
            'rows'              => $this->rows,
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
    public function setAttributeSelected()
    {
        $attr = $this->attribute;
        if (is_array($this->model->$attr)) {
            if (count($this->model->$attr) > 0) {
                for ($i = 0; $i < count($this->rows); $i++) {
                    $item = &$this->rows[ $i ];
                    $item['selected'] = in_array($item['id'], $this->model->$attr);
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

    /**
     * Возвращает массив идентификаторов которые были отмечены
     *
     * @param array           $field
     * @param \yii\base\Model $model
     *
     * @return array [1, 2, 3, ... ] массив идентификаторов
     */
    public static function getValue($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $value = ArrayHelper::getValue(Yii::$app->request->post(), $model->formName() . '.' . $fieldName, []);

        return $value;
    }
}
