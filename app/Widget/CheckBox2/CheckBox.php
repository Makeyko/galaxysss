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
use CreditSystem\App as CApplication;

/*
$options = [
];
*/


class CheckBox extends InputWidget
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
    ];

    /** @var  bool */
    public $checked;

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
        $options = ArrayHelper::merge($this->options, ['data-toggle' => 'toggle']);
        if ($this->textOn) $options['data-on'] = $this->textOn;
        if ($this->textOff) $options['data-off'] = $this->textOff;

        return Html::tag('div', Html::input('checkbox', $this->attrName, $this->checked, $options), ['style'=>'display:block;'] );
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
        $value = ArrayHelper::getValue(\Yii::$app->request->post(), $model->formName() . '.' . $fieldName, null);
        if ($value == '') $value = 0;
        if ($value == 1) $value = 1;

        return [
            $fieldName => $value,
        ];
    }
}
