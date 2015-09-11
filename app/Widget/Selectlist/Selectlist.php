<?php

namespace cs\Widget\Selectlist;

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
 * Класс Selectlist
 *
$field->widget('cs\Widget\Selectlist\Selectlist', [

]);
*/

class Selectlist extends InputWidget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    public $items = [];
    public $events = [];

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

        return Yii::$app->view->renderFile('@csRoot/Widget/Selectlist/template.php', [
            'items'      => $this->items,
            'fieldId'    => $this->fieldId,
            'fieldName'  => $this->fieldName,
        ]);
    }


    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        \app\assets\FuelUX\Asset::register($this->view);
        $this->options = ArrayHelper::merge($this->getClientOptions(), $this->options);
        $options = Json::encode($this->options);
        $this->getView()->registerJs(<<<JS
$('#{$this->fieldId}').selectlist({$options});
JS
        );
        if ($this->events) {
            foreach($this->events as $name => $function) {
                $this->getView()->registerJs(<<<JS
$('#{$this->fieldId}').on('{$name}', {$function});
JS
                );
            }
        }
    }

    /**
     * Возвращает опции для виджета
     *
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [];
    }

    /**
     * @param array $field
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
        $model->$fieldName = $row[$fieldName];
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
