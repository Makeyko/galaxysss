<?php

namespace cs\Widget\TimePiker;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\web\JsExpression;
use Imagine\Image\ManipulatorInterface;
use cs\base\BaseForm;
use cs\Widget\FileUploadMany\ModelFiles;
use cs\services\UploadFolderDispatcher;
use cs\services\SitePath;
use yii\jui\InputWidget;

/**
 * Класс ComboBox
 *
 * $field->widget('cs\Widget\TimePiker\TimePiker', [
 *
 * ]);
 */
class TimePiker extends InputWidget
{
    /**
     * @var array опции виджета
     */
    public $options = [];

    public $style = [
        'input' => [],
        'div'   => [],
    ];

    public $value;
    public $events;

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
        if ($this->model) {
            $model = $this->model;
            $attribute = $this->attribute;
            $this->value = $model->$attribute;
        }
    }

    public static function widget($config = [])
    {
        $class = new static($config);

        return $class->run();
    }

    /**
     * рисует виджет
     */
    public function run()
    {
        $this->registerClientScript();

        $inputOptions = ArrayHelper::merge($this->style['input'], [
            'id' => $this->fieldId,
           'class' => 'form-control input-small'
        ]);

        return Html::tag('div',
            Html::input('text', $this->fieldName, $this->value, $inputOptions) . '<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>'
            , [
                'class' => 'input-group bootstrap-timepicker timepicker'
            ]);
    }


    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        \cs\Widget\TimePiker\Asset::register($this->view);
        $this->options = ArrayHelper::merge($this->getClientOptions(), $this->options);
        $options = Json::encode($this->options);
        $this->getView()->registerJs(<<<JS
$('#{$this->fieldId}').timepicker({$options});
JS
        );
        if ($this->events) {
            foreach ($this->events as $name => $function) {
                $this->getView()->registerJs(<<<JS
$('#{$this->fieldId}').timepicker().on('{$name}', {$function});
JS
                );
            }
        }
    }

    /**
     * Возвращает опции для виджета по умолчанию
     *
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [
            'minuteStep'     => 1,
            'template'       => 'modal',
            'appendWidgetTo' => 'body',
            'showSeconds'    => false,
            'showMeridian'   => false,
            'defaultTime'    => false,
        ];
    }

    /**
     * @param array           $field
     * @param \yii\base\Model $model
     */
    public static function onLoad($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $post = Yii::$app->request->post();
        $query = $model->formName() . '.' . $fieldName;
        $model->$fieldName = ArrayHelper::getValue($post, $query, '');
    }

    /**
     *
     *
     * @param array             $field
     * @param \cs\base\BaseForm $model
     */
    public static function onLoadDb($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $row = $model->getRow();
        $model->$fieldName = $row[ $fieldName ];
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
