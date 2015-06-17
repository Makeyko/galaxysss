<?php

namespace cs\Widget\CheckBox;

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
    'label' => 'value1',
    'options' => [
        'span'    => ['class' => ''],
        'input'  => ['class' => ''],
        'label' => ['class' => ''],
    ],
    'nullValue' => 'Ничего не выбрано'
    'templateFile' => null
];

<label class="">
 <input type="checkbox" class="">
 <span></span>
 <span class="">{*text*}</span>
</label>

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
        'div'    => ['class' => ''],
        'input'  => ['class' => ''],
        'label1' => ['class' => ''],
        'label2' => ['class' => ''],
    ];

    public $label = '';
    public $nullString;
    public $templateFile;

    private $attrId;
    private $attrName;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        if ((is_null($this->templateFile))) {
            $this->templateFile = __DIR__ . '/CheckBox.tpl';
        }

        $key = '\cs\Widget\RadioList\CheckBox::init';
        $this->template = Yii::$app->cache->get($key);
        if ($this->template === false) {
            $this->template = file_get_contents($this->templateFile);
            Yii::$app->cache->set($key, $this->template);
        }

        $this->attrId = strtolower($this->model->formName() . '-' . $this->attribute);
        $this->attrName = $this->model->formName() . '[' . $this->attribute . ']';
    }

    /**
     * Renders the widget.
     * <div class="custom_label">
     * <input type="radio" class="" id="{*some_id*}" >
     * <label for="{*some_id*}" class="radio_imitation"></label>
     * <label for="{*some_id*}" class="radio_text">{*text*}</label>
     * </div>
     */
    public function run()
    {
        $this->registerClientScript();
        $fieldName = $this->attribute;
        echo Yii::$app->view->renderFile($this->templateFile, [
            'id'       => $this->attrId,
            'contnt'   => $this->label,
            'name'     => $this->attrName,
            'formName' => $this->model->formName(),
            'checked'  => ($this->model->$fieldName == 1),
        ]);
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
        $value = ArrayHelper::getValue(\Yii::$app->request->post(), $model->formName() . '.' . $fieldName, null);
        if ($value == '') $value = 0;
        if ($value == 1) $value = 1;

        return [
            $fieldName => $value,
        ];
    }

    /**
     * Рисует просмотр файла для детального просмотра
     *
     * @param \yii\base\Model $model
     * @param array           $field
     *
     * @return string
     */
    public static function drawDetailView($model, $field)
    {
        $fieldName = $field[ \cs\base\BaseForm::POS_DB_NAME ];
        $value = $model->$fieldName;
        if (is_null($value)) {
            return ArrayHelper::getValue($value, 'type.1.nullString', '<Нет значения>');
        }
        $list = ArrayHelper::getValue($value, 'type.1.list', []);

        return $list[ $value ];
    }
}
