<?php

namespace cs\Widget\PlaceMap;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\widgets\InputWidget;
use yii\web\UploadedFile;
use yii\web\JsExpression;
use yii\imagine\Image;
use Imagine\Image\ManipulatorInterface;
use cs\base\BaseForm;
use CreditSystem\App as CApplication;

/**
 * class PlaceMap
 *
 * Опции виджета:
 * ```php
 * $options = [
 *     'style' => [
 *                'input' => ''
 *                'divMap' => ''
 *                ]
 * ]);
 * ```
 *
 * Использование:
 *
 * ```php
 * $form->input($model, 'name')->widget(PlaceMap::className(), $options)
 * ```
 */
class PlaceMap extends InputWidget
{
    private $fieldId;
    private $fieldName;

    private $fieldIdMap;
    private $fieldNameMap;

    private $fieldIdLat;
    private $fieldNameLat;

    private $fieldIdLng;
    private $fieldNameLng;

    public $style = [
        'input'  => ['class' => 'form-control'],
        'divMap' => [],
    ];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $formName = $this->model->formName();
        $this->getId();

        $this->fieldId = strtolower($formName . '-' . $this->attribute);
        $this->fieldName = $formName . '[' . $this->attribute . ']';

        $this->fieldIdMap = strtolower($formName . '-' . $this->attribute . '-map');
        $this->fieldNameMap = $formName . '[' . $this->attribute . '-map' . ']';

        $this->fieldIdLng = strtolower($formName . '-' . $this->attribute . '-lng');
        $this->fieldNameLng = $formName . '[' . $this->attribute . '-lng' . ']';

        $this->fieldIdLat = strtolower($formName . '-' . $this->attribute . '-lat');
        $this->fieldNameLat = $formName . '[' . $this->attribute . '-lat' . ']';
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
        $html = [];

        if ($this->hasModel()) {
            $fieldNameLng = $this->attribute . '_lng';
            $fieldNameLat = $this->attribute . '_lat';
            $lng = null;
            $lat = null;
            if (isset($this->model->$fieldNameLng)) {
                $lng = $this->model->$fieldNameLng;
            }
            if (isset($this->model->$fieldNameLat)) {
                $lat = $this->model->$fieldNameLat;
            }

            // hidden
            $html[] = Html::input('hidden', $this->fieldNameLng, $lng, ['id' => $this->fieldIdLng]);
            $html[] = Html::input('hidden', $this->fieldNameLat, $lat, ['id' => $this->fieldIdLat]);

            // input
            $inputAttributes = ArrayHelper::getValue($this->style, 'input', []);
            $inputAttributes = ArrayHelper::merge($inputAttributes, ['id' => $this->fieldId]);
            $html[] = Html::input('text', $this->fieldName, null, $inputAttributes);

            // divMap
            $divMapAttributes = ArrayHelper::getValue($this->style, 'divMap', []);
            $divMapAttributes = ArrayHelper::merge([
                'id'    => $this->fieldIdMap,
                'class' => 'widgetPlaceMap-map'
            ], $divMapAttributes);
            $html[] = Html::tag('div', null, $divMapAttributes);
        }
        else {

        }

        return join("\r\n", $html);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        Asset::register($this->getView());
        $options = ["'{$this->fieldId}'"];

        $fieldNameLng = $this->attribute . '_lng';
        $fieldNameLat = $this->attribute . '_lat';
        $lng = null;
        $lat = null;
        if (isset($this->model->$fieldNameLng)) {
            $lng = $this->model->$fieldNameLng;
        }
        if (isset($this->model->$fieldNameLat)) {
            $lat = $this->model->$fieldNameLat;
        }
        if (!is_null($lng) && !is_null($lat)) {
            $optionsExt = [
                'lat' => $lat,
                'lng' => $lng,
            ];
            $options[] = json_encode($optionsExt);
        }
        $optionsString = join(',', $options);

        $this->getView()->registerJs("PlaceMap.init({$optionsString});");
    }

    /**
     * Returns the options for the captcha JS widget.
     *
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [];
    }

    /**
     *
     * @param array           $field
     * @param \yii\base\Model $model
     *
     * @return array
     */
    public static function onUpdate($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        $lng = self::getParam($fieldName . '-lng', $model);
        $lat = self::getParam($fieldName . '-lat', $model);
        $address = self::getParam($fieldName, $model);
        if ($lng == '') $lng = null;
        if ($lat == '') $lat = null;
        if ($address == '') $address = null;

        return [
            $fieldName . '_lat'     => $lat,
            $fieldName . '_lng'     => $lng,
            $fieldName . '_address' => $address,
        ];
    }

    /**
     *
     * @param array           $field
     * @param \yii\base\Model $model
     *
     * @return array
     */
    public static function onInsert($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        $lng = self::getParam($fieldName . '-lng', $model);
        $lat = self::getParam($fieldName . '-lat', $model);
        $address = self::getParam($fieldName, $model);
        if ($lng == '') $lng = null;
        if ($lat == '') $lat = null;
        if ($address == '') $address = null;

        return [
            $fieldName . '_lat'     => $lat,
            $fieldName . '_lng'     => $lng,
            $fieldName . '_address' => $address,
        ];
    }



    /**
     * Возвращает значение поля формы из поста
     *
     * @param string          $fieldName
     * @param \yii\base\Model $model
     *
     * @return string
     */
    public static function getParam($fieldName, $model)
    {
        $formName = $model->formName();
        $query = $formName . '.' . $fieldName;

        return ArrayHelper::getValue(\Yii::$app->request->post(), $query, '');
    }
}
