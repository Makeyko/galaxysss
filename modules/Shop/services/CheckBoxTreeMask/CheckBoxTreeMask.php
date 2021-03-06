<?php

namespace app\modules\Shop\services\CheckBoxTreeMask;

use Yii;
use yii\base\InvalidConfigException;
use yii\debug\models\search\Debug;
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
use yii\db\Query;

/**
 * Виджет для вывода списка chackbox'ов по шаблону
 * Данные сохраняет в БД в виде маски
 *
 * Можно на лету online добавлять новые элементы и удалять
 * Обладать таким правом могут только админы
 * в \cs\Widget\CheckBoxTreeMask\Controller указан фильтр доступа
 *
 * - tableName - string - таблица
 * - rootId - int - идентификатор корневой ветки
 *
 * - templateFile - string - шаблон для виджета
 * - templateVariables - array - параметры передаваемые в шаблон
 */
class CheckBoxTreeMask extends InputWidget
{
    public $templateFile = '@app/modules/Shop/services/CheckBoxTreeMask/template';
    public $templateVariables = [];

    /** @var  int */
    public $union_id;

    public $rows;

    private $attrId;
    private $attrName;

    public $tableName;
    public $rootId;
    /**
     * @var array, string
     *           поля для выборки, нужно вернуть поля id и name
     */
    public $select = 'id, name';

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
        $rows = $this->getRows($this->rootId);
        $attribute = $this->attribute;
        $value = $this->model->$attribute;

        return $this->render($this->templateFile, [
            'rows'              => $rows,
            'tableName'         => $this->tableName,
            'formName'          => $this->model->formName(),
            'model'             => $this->model,
            'attrId'            => $this->attrId,
            'attrName'          => $this->attrName,
            'templateVariables' => $this->templateVariables,
            'value'             => $value,
            'union_id'          => $this->union_id,
        ]);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        Asset::register(\Yii::$app->view);
    }

    /**
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [];
    }

    /**
     * Возвращает элементы списка
     * @return array
     * [[
     *  'id' =>
     *  'name' =>
     *  'nodes' => array
     * ], ... ]
     */
    public function getRows($parentId)
    {
        $rows = (new Query())
            ->select($this->select)
            ->from($this->tableName)
            ->where([
                'parent_id' => $parentId,
                'union_id'  => $this->union_id,
            ])
            ->orderBy(['sort_index' => SORT_ASC])
            ->all();
        for ($i = 0; $i < count($rows); $i++) {
            $item = &$rows[ $i ];
            $rows2 = $this->getRows($item['id']);
            if (count($rows2) > 0) {
                $item['nodes'] = $rows2;
            }
        }

        return $rows;
    }

    /**
     * Берет значения из POST и возвраает знаяения для добавления в БД
     *
     * @param array $field
     * @param \yii\base\Model $model
     *
     * @return array
     */
    public static function onUpdate($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        return [
            $fieldName => $model->$fieldName
        ];
    }
}
