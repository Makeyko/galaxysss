<?php

namespace cs\Widget\CheckBoxList;

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
use CreditSystem\App as CApplication;

/**
 *
 * Виджет для вывода списка chackbox'ов по шаблону
 *
 *
 * - rows строки для виджета
 * [['id'=>,'name'=>, ], ...]
 *
 * - templateFile шаблон для виджета

 */
class CheckBoxList extends InputWidget
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
    public $nullString;
    public $templateFile      = '@csRoot/Widget/CheckBoxList/CheckBoxList.tpl';
    public $templateVariables = [];

    private $attrId;
    private $attrName;
    public  $rows;
    public  $callbackDrawRow;

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
     *
     *
     * <div class="bank_list_row">
     *
     * <div class="bank_list_check">
     * <input type="checkbox" value="" name="" id="{*id*}" class="display_none">
     * <label for="{*id*}">
     * </label>
     * </div>
     *
     * <a href="{*ссылка на профиль банка*}" class="bank_list_name">
     * <span class="bank_logo" style="background-image:'url({*путь к логотипу банка*})'"></span>
     * <span class="bank_name">{*Название банка*}</span>
     * </a>
     *
     *
     * <a href="{*ссылка на отзывы о банке*}" class="bank_list_reviews">
     * {Количество отзывов}
     * </a>
     *
     * <div class="bank_list_rating">
     * {Рейтинг}
     * </div>
     *
     * </div>



     */
    public function run()
    {
        $this->registerClientScript();

        if (!is_null($this->callbackDrawRow)) {
            $callback = $this->callbackDrawRow;

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
        $js = <<<JSSSS
$('#{$this->attrId}-check-all').click(function() {
    if ($('#{$this->attrId}-check-all-input').is(':checked') == false) {
        $.each($('input[name="{$this->attrName}[]"]'), function(index, value){
            $(this).prop('checked', 'checked');
        })
        $('#{$this->attrId}-check-all-input').prop('checked', 'checked');
    } else {
        $.each($('input[name="{$this->attrName}[]"]'), function(index, value) {
            $(this).prop('checked', '');
        })
        $('#{$this->attrId}-check-all-input').prop('checked', '');
    }
});
JSSSS;
        $this->getView()->registerJs(new JsExpression($js));
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
        return [];
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
