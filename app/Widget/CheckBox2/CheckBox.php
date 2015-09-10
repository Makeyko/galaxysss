<?php

namespace cs\Widget\CheckBox2;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\widgets\InputWidget;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use cs\base\BaseForm;

/**
 * http://www.bootstraptoggle.com
 *
$options = [
];
*/


class CheckBox extends InputWidget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [
    ];

    private $attrId;
    private $attrName;

    public $textOn = 'Да';
    public $textOff = 'Нет';

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
     * Renders the widget.
     */
    public function run()
    {

        $this->registerClientScript();
        $options = ArrayHelper::merge($this->options, [
            'data-toggle' => 'toggle',
        ]);
        $fieldName = $this->attribute;
        if ($this->model->$fieldName) $options['checked'] = 'checked';
        if ($this->textOn) $options['data-on'] = $this->textOn;
        if ($this->textOff) $options['data-off'] = $this->textOff;

        return Html::tag('div', Html::input('checkbox', $this->attrName, 1, $options), ['style' => 'display:block;'] );
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        \cs\assets\CheckBox\Asset::register(Yii::$app->view);
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
    public static function onLoad($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $value = ArrayHelper::getValue(\Yii::$app->request->post(), $model->formName() . '.' . $fieldName, false);
        if ($value) $value = true;

        $model->$fieldName = $value;
    }

    /**
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return array поля для обновления в БД
     */
    public static function onLoadDb($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $row = $model->getRow();
        if (isset($row[$fieldName])) {
            $model->$fieldName = ($row[$fieldName] == 1);
        } else {
            $model->$fieldName = false;
        }
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

        return [
            $fieldName => ($model->$fieldName)? 1 : 0,
        ];
    }
}
