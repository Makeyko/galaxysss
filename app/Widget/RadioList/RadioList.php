<?php

namespace cs\Widget\RadioList;

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
use CreditSystem\Application as CApplication;

/*
$options = [
    'list' => [
        '1' => 'value1',
        '2' => 'value2',
    ],
    'options' => [
        'div'    => ['class' => ''],
        'input'  => ['class' => ''],
        'label1' => ['class' => ''],
        'label2' => ['class' => ''],
    ],
    'nullString' => 'Ничего не выбрано'
];
*/


class RadioList extends InputWidget
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

    public $list = [];
    public $nullString;

    private $attrId;
    private $attrName;

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
     * <div class="custom_label">
     * <input type="radio" class="" id="{*some_id*}" >
     * <label for="{*some_id*}" class="radio_imitation"></label>
     * <label for="{*some_id*}" class="radio_text">{*text*}</label>
     * </div>
     */
    public function run()
    {
        $this->registerClientScript();
        $html = [];
        if ($this->hasModel()) {
            $fieldName = $this->attribute;
            $valueField = $this->model->$fieldName;
            if (!is_null($this->nullString)) {
                $item = [];
                if (in_array($valueField, $this->list)) {
                    $id = $this->attrId . '-null';
                    $item[] = Html::radio($this->attrName, false, ArrayHelper::merge(['id'    => $id,
                                                                                      'value' => ''
                    ], $this->options['input']));
                    $item[] = Html::label('', $id, $this->options['label1']);
                    $item[] = Html::label($this->nullString, $id, $this->options['label2']);
                } else {
                    $id = $this->attrId . '-null';
                    $item[] = Html::radio($this->attrName, true, ArrayHelper::merge(['id'    => $id,
                                                                                     'value' => ''
                    ], $this->options['input']));
                    $item[] = Html::label('', $id, $this->options['label1']);
                    $item[] = Html::label($this->nullString, $id, $this->options['label2']);
                }
                $html[] = Html::tag('div', join('', $item), $this->options['div']);
            }
            foreach ($this->list as $key => $value) {
                $item = [];
                $id = $this->attrId . '-' . $key;
                if (is_null($valueField)) {
                    $checked = false;
                } else {
                    $checked = ($valueField == $key);
                }
                $item[] = Html::radio($this->attrName, $checked, ArrayHelper::merge(['id'    => $id,
                                                                                                  'value' => $key
                ], $this->options['input']));
                $item[] = Html::label('', $id, $this->options['label1']);
                $item[] = Html::label($value, $id, $this->options['label2']);
                $html[] = Html::tag('div', join('', $item), $this->options['div']);
            }
        }

        echo join('', $html);
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
        if ($value == '') $value = null;

        return [$fieldName => $value];
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
