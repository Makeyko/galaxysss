<?php

namespace cs\Widget\Place;

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
use cs\models\Place\Country;
use cs\models\Place\Region;
use cs\models\Place\Town;
use CreditSystem\Application as CApplication;

/*
->widget(Place::className(),
[
    'options'             => [],
    'countryInputOptions' => [],
    'regionInputOptions'  => [],
    'townInputOptions'    => [],
]);
*/

class Place extends InputWidget
{
    /**
     * @var string the template for arranging the CAPTCHA image tag and the text input tag.
     * In this template, the token `{image}` will be replaced with the actual image tag,
     * while `{input}` will be replaced with the text input tag.
     */
    public $template = '{input}';
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'form-control'];

    public $countryInputOptions;
    public $regionInputOptions;
    public $townInputOptions;

    private $fieldIntCountryId;
    private $fieldIntCountryName;
    private $fieldTextCountryId;
    private $fieldTextCountryName;

    private $fieldIntRegionId;
    private $fieldIntRegionName;
    private $fieldTextRegionId;
    private $fieldTextRegionName;

    private $fieldIntTownId;
    private $fieldIntTownName;
    private $fieldTextTownId;
    private $fieldTextTownName;

    private $fieldGroup1Id;
    private $fieldGroup2Id;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $formName = $this->model->formName();
        $attr = $this->attribute;
        $attrCountry = $attr . '_country';
        $attrRegion = $attr . '_region';
        $attrTown = $attr . '_town';

        $this->fieldIntCountryId = strtolower($formName . '-' . $attrCountry);
        $this->fieldIntCountryName = $formName . '[' . $attrCountry . ']';
        $this->fieldTextCountryId = strtolower($formName . '-' . $attrCountry) . '-name';
        $this->fieldTextCountryName = $formName . '[' . $attrCountry . '-name' . ']';

        $this->fieldIntRegionId = strtolower($formName . '-' . $attrRegion);
        $this->fieldIntRegionName = $formName . '[' . $attrRegion . ']';
        $this->fieldTextRegionId = strtolower($formName . '-' . $attrRegion) . '-name';
        $this->fieldTextRegionName = $formName . '[' . $attrRegion . '-name' . ']';

        $this->fieldIntTownId = strtolower($formName . '-' . $attrTown);
        $this->fieldIntTownName = $formName . '[' . $attrTown . ']';
        $this->fieldTextTownId = strtolower($formName . '-' . $attrTown) . '-name';
        $this->fieldTextTownName = $formName . '[' . $attrTown . '-name' . ']';

        $this->fieldGroup1Id = strtolower($formName . '-' . $attr) . '-group1';
        $this->fieldGroup2Id = strtolower($formName . '-' . $attr) . '-group2';
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
        $html = [];
        $view = $this->getView();
        if ($this->hasModel()) {
            $fieldName = $this->attribute;
            $html[] = Html::tag('p', 'Страна');
            $html[] = $this->renderItem2('country', $view);
            $html[] = "<div id='{$this->fieldGroup1Id}'>";
            $html[] = Html::tag('p', 'Регион');
            $html[] = $this->renderItem2('region', $view);

            $html[] = "<div id='{$this->fieldGroup2Id}'>";
            $html[] = Html::tag('p', 'Город');
            $html[] = $this->renderItem2('town', $view);
            $html[] = '</div>';
            $html[] = '</div>';
        } else {

        }
        echo join('', $html);
    }

    private function renderItem2($key, $view)
    {
        $source = "/place/{$key}";
        $keyU = strtoupper(substr($key, 0, 1)) . substr($key, 1);
        $fieldTextId = "fieldText{$keyU}Id";
        $fieldTextName = "fieldText{$keyU}Name";
        $fieldIntId = "fieldInt{$keyU}Id";
        $fieldIntName = "fieldInt{$keyU}Name";
        $html[] = $this->renderItem($this->$fieldTextId, $this->$fieldTextName, $view, $source, $this->$fieldIntId, $key);

        $attrName = $this->attribute . '_' . $key;
        $value = null;
        if ($this->model->hasProperty($attrName)) {
            $value = $this->model->$attrName;
        }

        $html[] = Html::input('hidden', $this->$fieldIntName, $value, ['id' => $this->$fieldIntId]);

        return join('', $html);
    }

    private function renderItem($id, $name, \yii\web\View $view, $source, $idInt, $key)
    {
        // добавляю опции input'а
        $optionsName = $key . 'InputOptions';
        $inputOptions = $this->$optionsName;
        if (!is_null($inputOptions)) {
            if (ArrayHelper::keyExists('class', $inputOptions)) {
                $inputOptions['class'] .= ' form-control ui-autocomplete-input';
            } else {
                $inputOptions['class'] = 'form-control ui-autocomplete-input';
            }
        } else {
            $inputOptions = [
                'class' => 'form-control ui-autocomplete-input',
            ];
        }

        $attrName = $this->attribute . '_' . $key;
        $value = null;
        if ($this->model->hasProperty($attrName)) {
            $value = $this->model->$attrName;
            if (!is_null($value)) {
                switch ($key) {
                    case 'town':
                        $value = Town::find($value)->getName();
                        break;
                    case 'region':
                        $value = Region::find($value)->getName();
                        break;
                    case 'country':
                        $value = Country::find($value)->getName();
                        break;
                }
            }
        }

        return Html::input('text', $name, $value, ArrayHelper::merge($inputOptions, [
            'id'           => $id,
            'autocomplete' => 'off',
        ]));
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        \cs\Widget\Place\Asset::register($this->getView());
        $id  = strtolower($this->model->formName() . '-' . $this->attribute );
        $this->getView()->registerJs("Place.init('{$id}');");
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
        $post = \Yii::$app->request->post()[ $model->formName() ];
        $fieldIntCountry = $fieldName . '_country';
        $fieldIntRegion = $fieldName . '_region';
        $fieldIntTown = $fieldName . '_town';

        $fieldTextCountry = $fieldName . '_country-name';
        $fieldTextRegion = $fieldName . '_region-name';
        $fieldTextTown = $fieldName . '_town-name';

        $valueTextCountry = ArrayHelper::getValue($post, $fieldTextCountry, '');
        $valueTextRegion = ArrayHelper::getValue($post, $fieldTextRegion, '');
        $valueTextTown = ArrayHelper::getValue($post, $fieldTextTown, '');
        if ($valueTextCountry == '' && $valueTextRegion == '' && $valueTextTown == '') {
            return [
                $fieldIntCountry => null,
                $fieldIntRegion  => null,
                $fieldIntTown    => null,
            ];
        }
        if ($valueTextCountry != '' && $valueTextRegion == '' && $valueTextTown == '') {
            return [
                $fieldIntCountry => ArrayHelper::getValue($post, $fieldIntCountry, null),
                $fieldIntRegion  => null,
                $fieldIntTown    => null,
            ];
        }
        if ($valueTextCountry != '' && $valueTextRegion != '' && $valueTextTown == '') {
            return [
                $fieldIntCountry => ArrayHelper::getValue($post, $fieldIntCountry, null),
                $fieldIntRegion  => ArrayHelper::getValue($post, $fieldIntRegion, null),
                $fieldIntTown    => null,
            ];
        }

        return [
            $fieldIntCountry => ArrayHelper::getValue($post, $fieldIntCountry, null),
            $fieldIntRegion  => ArrayHelper::getValue($post, $fieldIntRegion, null),
            $fieldIntTown    => ArrayHelper::getValue($post, $fieldIntTown, null),
        ];
    }

}
