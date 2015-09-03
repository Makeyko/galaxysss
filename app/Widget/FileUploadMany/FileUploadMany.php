<?php

namespace cs\Widget\FileUploadMany;

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
 * Класс FileUploadMany
 *
 * Виджет который загружает файлы по несколько штук
 *
 * Максимальный размер загружаемого файла по умолчанию устанавливается равный тому который указан в параметре ini.php upload_max_filesize
 *


$field->widget('cs\Widget\FileUploadMany\FileUploadMany', [

]);

$options = [
    'serverName'
];

$model->$fieldName = [
    ['file_path', 'file_name'],
];
*/

class FileUploadMany extends InputWidget
{
    const MODE_THUMBNAIL_INSET    = ManipulatorInterface::THUMBNAIL_INSET;
    const MODE_THUMBNAIL_OUTBOUND = ManipulatorInterface::THUMBNAIL_OUTBOUND;

    public static $uploadDirectory = '@runtime/uploads/FileUploadMany';
    public static $tableNameFiles  = 'widget_uploader_many';
    public static $tableNameFields = 'widget_uploader_many_fields';


    /**
     * @var string the template for arranging the CAPTCHA image tag and the text input tag.
     * In this template, the token `{image}` will be replaced with the actual image tag,
     * while `{input}` will be replaced with the text input tag.
     */
    public $template = "<div class='upload'>\n{image}\n{checkbox}\n{input}\n</div>";

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    private $tableName;

    private $fieldId;
    private $fieldName;
    private $hiddenId;
    private $hiddenName;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->fieldId = strtolower($this->model->formName() . '-' . $this->attribute);
        $this->fieldName = $this->model->formName() . '[' . $this->attribute . ']';
        $this->hiddenId = strtolower($this->model->formName() . '-' . $this->attribute . '-files');
        $this->hiddenName = $this->model->formName() . '[' . $this->attribute . '-files' . ']';
    }

    /**
     * рисует виджет
     */
    public function run()
    {
        $this->registerClientScript();

        if ($this->hasModel()) {
            $attribute = $this->attribute;

            $files = $this->model->$attribute;
            if (is_null($files)) $files = [];
            $this->clientOptions['files'] = $files;
            $c1 = Html::hiddenInput($this->hiddenName, json_encode($this->clientOptions['files'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), ['id' => $this->hiddenId]);
            $c2 = Html::fileInput($this->fieldName, null, ['id' => $this->fieldId]);

            return Html::tag('div', $c1 . $c2, ['class' => 'multifile_upload']);
        }
    }

    private function renderTemplate($params)
    {
        $t = $this->template;
        foreach ($params as $key => $value) {
            $t = str_replace('{' . $key . '}', $value, $t);
        }

        return $t;
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        Asset::register($this->view);
        $this->clientOptions = ArrayHelper::merge($this->getClientOptions(), $this->clientOptions);
        $options = Json::encode($this->clientOptions);
        $js = <<<JSSSS
FileUploadMany.init('#{$this->fieldId}', {$options});
JSSSS;
        $this->getView()->registerJs($js);
    }



    /**
     * Возвращает опции для виджета
     *
     * @return array the options
     */
    protected function getClientOptions()
    {
        return [
            'url'         => '/upload/upload',
            'maxFileSize' => self::getUploadMaxFileSize(),
        ];
    }

    /**
     * Возвращает максимально возможно загружаемый файл который установлен в настройках PHP
     *
     * @return int в байтах
     */
    private static function getUploadMaxFileSize()
    {
        $maxFileSize = ini_get('upload_max_filesize');
        return (int)substr($maxFileSize, 0, strlen($maxFileSize) - 1) * 1024 * 1024;
    }

    /**
     * @param array $field
     * @param \yii\base\Model $model
     *
     * @return array поля для обновления в БД
     */
    public static function onLoad($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $post = Yii::$app->request->post();
        $query = $model->formName() . '.' . $fieldName . '-files';
        $filesString = ArrayHelper::getValue($post, $query, '');
        $model->$fieldName = json_decode($filesString);
    }

    /**
     *
     *
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return array поля для обновления в БД
     */
    public static function onLoadDb($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $files = (new Query())
            ->select('w.file_path, w.file_name')
            ->from('widget_uploader_many w')
            ->innerJoin('widget_uploader_many_fields wf', 'w.field_id = wf.id')
            ->where([
                'w.row_id'      => $model->id,
                'wf.table_name' => $model->getTableName(),
                'wf.field_name' => $fieldName
            ])
            ->all();
        $rows = [];
        foreach($files as $file) {
            $rows[] = [$file['file_path'],$file['file_name']];
        }

        $model->$fieldName = $rows;
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
        $files = $model->$fieldName;
        $tableName = $model->getTableName();

        $fieldDb = ModelFields::insertOne([
            'table_name' => $tableName,
            'field_name' => $fieldName,
        ]);

        ModelFiles::deleteByCondition([
            'row_id' => $fieldDb->getId(),
        ]);
        $folder = \cs\services\UploadFolderDispatcher::createFolder('FileUploadMany', $fieldDb->getId(), $model->id);
        $allFiles = [];
        foreach ($files as $file) {
            $allFiles[] = $file[0];
        }
        $currentFiles = (new Query())
            ->select('w.file_path, w.id')
            ->from('widget_uploader_many w')
            ->innerJoin('widget_uploader_many_fields wf', 'w.field_id = wf.id')
            ->where([
                'w.row_id'      => $model->id,
                'wf.table_name' => $model->getTableName(),
                'wf.field_name' => $fieldName
            ])
            ->all();
        foreach ($currentFiles as $currentFile) {
            if (!in_array($currentFile['file_path'], $allFiles)) {
                (new SitePath($currentFile['file_path']))->deleteFile();
                $id = (int)$currentFile['id'];
                ModelFiles::deleteByCondition(['id' => $id]);
            }
        }
        foreach ($files as $file) {
            if (StringHelper::startsWith($file[0], '/')) {
                continue;
            }
            $sourcePathFull = Yii::getAlias(self::$uploadDirectory . '/' . $file[0]);
            $destinationFile = $folder->cloneObject($file[0]);
            copy($sourcePathFull, $destinationFile->getPathFull());
            ModelFiles::insert([
                'file_path' => $destinationFile->getPath(),
                'file_name' => $file[1],
                'row_id'    => $model->id,
                'field_id'  => $fieldDb->getId(),
                'datetime'  => gmdate('YmdHis'),
            ]);
        }

        return [
            $fieldName => count($files),
        ];
    }

    /**
     * Возвращает ссылку для скачивания файла
     *
     * @return string
     */
    public static function getDownloadLink($id)
    {
        return 'upload/download/' . $id;
    }

    /**
     * Рисует просмотр файла для детального просмотра
     *
     * @param \yii\base\Model $model
     * @param array           $field
     *
     * @return string
     *
     */
    public static function drawDetailView($model, $field)
    {
        return self::onDetailView($model, $field);
    }

    /**
     * Рисует просмотр файла для детального просмотра
     *
     * @param \yii\base\Model $model
     * @param array           $field
     *
     * @return string
     *
     */
    public static function onDetailView($model, $field)
    {
        return 'FileUploadMany';
    }

    /**
     * Удаляет
     *
     * @param \cs\base\BaseForm | \cs\models\DbRecord $model
     * @param array                                   $field
     *
     * @return string
     */
    public static function onDelete($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $fieldId = self::getFieldId($model->getTableName(), $fieldName);
        $files = (new Query())->select('file_path, id')->from(self::$tableNameFiles)->where([
            'row_id'   => $model->id,
            'field_id' => $fieldId,
        ])->all();

        foreach ($files as $file) {
            (new SitePath($file))->deleteFile();
        }
    }

    /**
     * Рисует просмотр файла для детального просмотра
     *
     * @param \cs\base\BaseForm | \cs\base\DbRecord $model
     * @param array                                   $field
     *
     * @return string
     */
    public static function onDraw($field, $model)
    {
        $html = [];
        $serverName = ArrayHelper::getValue($field, 'widget.1.options.serverName', '');
        $rows = self::getFiles($model->getTableName(), $field[ \cs\base\BaseForm::POS_DB_NAME ], $model->getId());
        foreach ($rows as $row) {
            $href = $row['file_path'];
            if ($serverName != '') $href = '//' . $serverName . $href;
            $html[] = Html::a($row['file_name'], $href, ['target' => '_blank']);
            $html[] = Html::tag('br');
        }

        return join("\r", $html);
    }

    /**
     * Выдает список файлов в поле
     *
     * @param string $tableName  название таблицы
     * @param string $fieldName  название поля
     * @param int    $rowId      идентификатор строки
     * @param string $serverName имя сервера для ссылок файлов, если задано то оно будет прибавлено к именам в формате "//{$serverName}/ss/..."
     *
     * @return array
     * [[
     *    'id'        => int
     *    'file_path' => str
     *    'file_name' => str
     *    'datetime'  => str
     * ], ...]
     */
    public static function getFiles($tableName, $fieldName, $rowId, $serverName = null)
    {
        $fieldId = self::getFieldId($tableName, $fieldName);
        if ($fieldId === false) return [];

        $select = [
            'id',
            'file_name',
            'UNIX_TIMESTAMP(datetime) as datetime'
        ];
        if (is_null($serverName)) {
            $select[] = 'file_path';
        } else {
            $select[] = "concat('//{$serverName}',`file_path`) as file_path";
        }

        return (new Query())->select($select)->from(self::$tableNameFiles)->where([
            'row_id'   => $rowId,
            'field_id' => $fieldId,
        ])->orderBy('datetime DESC')->all();
    }

    /**
     * Возвращает FieldId
     *
     * @param $tableName
     * @param $fieldName
     *
     * @return false|int
     */
    public static function getFieldId($tableName, $fieldName)
    {
        return (new Query())->select('id')->from(self::$tableNameFields)->where([
            'table_name' => $tableName,
            'field_name' => $fieldName,
        ])->scalar();
    }
}
