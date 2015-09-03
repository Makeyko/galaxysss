<?php

namespace cs\Widget\FileUpload;

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
    'delete' => [
        'input' => [],
        'label' => [],
    ],
    'inputFile' => [],
];

<label class="checkbox_imitation">
    <input type="checkbox" class="checkbox_hidden" name="{$name}" value="1" {if ($checked)}checked="checked"{/if}>
    <span></span>
    <span class="checkbox_text">{$contnt}</span>
</label>
*/


class FileUpload extends InputWidget
{
    const MODE_THUMBNAIL_INSET    = ManipulatorInterface::THUMBNAIL_INSET;
    const MODE_THUMBNAIL_OUTBOUND = ManipulatorInterface::THUMBNAIL_OUTBOUND;
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
    public $options = [
        'deleteCheckbox' => [
            'input' => [],
            'label' => [],
        ],
        'inputFile'      => [
            'class' => 'form-control'
        ],
    ];

    private $fieldIdName;
    private $actionIdName;
    private $actionNameAttribute;
    private $isDeleteNameAttribute;
    private $isDeleteIdName;
    private $valueNameAttribute;
    private $valueIdName;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->valueNameAttribute = $this->model->formName() . '[' . $this->attribute . '-value' . ']';
        $this->valueIdName = strtolower($this->model->formName() . '-' . $this->attribute) . '-value';

        $this->actionNameAttribute = $this->model->formName() . '[' . $this->attribute . '-action' . ']';
        $this->actionIdName = strtolower($this->model->formName() . '-' . $this->attribute) . '-action';

        $this->fieldIdName = strtolower($this->model->formName() . '-' . $this->attribute);

        $this->isDeleteNameAttribute = $this->model->formName() . '[' . $this->attribute . '-is-delete' . ']';
        $this->isDeleteIdName = strtolower($this->model->formName() . '-' . $this->attribute) . '-is-delete';

    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerClientScript();
        if ($this->hasModel()) {
            $fieldName = $this->attribute;
            $value = $this->model->$fieldName;
            $image = '';
            $checkbox = '';
            if (isset($value)) {
                if ($value != '') {
                    $image = Html::img($value, [
                        'width' => 200,
                        'class' => 'thumbnail',
                    ]);
                    if (self::isSmall($value)) {
                        $original = self::getOriginal($value);
                        $image = Html::a($image, $original, ['target' => '_blank']);
                    }
                    $checkbox = $this->getCheckbox();
                    $checkbox .= Html::hiddenInput($this->valueNameAttribute, $value, ['id' => $this->valueIdName]);
                }
            }
            $options = ArrayHelper::getValue($this->options, 'inputFile', []);
            $input = Html::activeFileInput($this->model, $this->attribute, $options);
        }

        echo $this->renderTemplate([
            'image'    => $image,
            'checkbox' => $checkbox,
            'input'    => $input,
        ]);
    }

    private function getCheckbox()
    {
        $input = Html::checkbox($this->isDeleteNameAttribute, null, [
            'value' => 1,
            'class' => 'checkbox_hidden',
            'id'    => $this->isDeleteIdName,
        ]);
        $c1 = Html::tag('span');
        $c2 = Html::tag('span', 'Удалить', [
            'class' => 'checkbox_text',
        ]);
        $label = Html::label($input . $c1 . $c2, null, [
            'class' => 'checkbox_imitation',
        ]);

        return $label;
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
     * @param array           $field
     * @param \yii\base\Model $model
     *
     * @return string
     */
    public static function onUpdate($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        $basePath = Yii::getAlias('@webroot');
        $fileModel = UploadedFile::getInstance($model, $fieldName);
        $post = Yii::$app->request->post();
        $postForm = $post[ $model->formName() ];
        $query = $model->formName() . '.' . $fieldName . '-is-delete';
        $is_delete = ArrayHelper::getValue($post, $query, 0);
        if (is_null($fileModel)) {
            $query = $model->formName() . '.' . $fieldName . '-value';
            $value = ArrayHelper::getValue($post, $query, '');
            if ($is_delete == 0) {
                return $value;
            }

            // удаляем
            $path = $basePath . $value;
            if (file_exists($path)) {
                unlink($path);
            }

            return [
                $fieldName => ''
            ];
        }
        if ($fileModel->error > 0) {
            return [
                $fieldName => ''
            ];
        }
        $folder = ArrayHelper::getValue($field, 'type.1.folder', $model->formName());

        $idLength = 8;
        $userId = $model->id; //
        $fieldFolder = '/upload/' . $folder;
        $fieldFolderPath = $basePath . $fieldFolder;
        if (!file_exists($fieldFolderPath)) {
            mkdir($fieldFolderPath);
        }
        $userFolder = $fieldFolder . '/' . str_repeat('0', $idLength - strlen($userId)) . $userId;
        $userFolderPath = $basePath . $userFolder;
        if (!file_exists($userFolderPath)) {
            mkdir($userFolderPath);
        }
        $folderSmall = $userFolder . '/small';
        $folderSmallPath = $userFolderPath . '/small';
        if (!file_exists($folderSmallPath)) {
            mkdir($folderSmallPath);
        }
        $folderOriginal = $userFolder . '/original';
        $folderOriginalPath = $userFolderPath . '/original';
        if (!file_exists($folderOriginalPath)) {
            mkdir($folderOriginalPath);
        }

        $filePath = $folderOriginal . '/' . $fieldName . '.' . $fileModel->extension;
        $filePathFull = $basePath . $filePath;
        $filePathFull = \yii\helpers\FileHelper::normalizePath($filePathFull);

        $fileSmall = $folderSmall . '/' . $fieldName . '.' . $fileModel->extension;
        $fileSmallPath = $basePath . $fileSmall;
        $fileSmallPath = \yii\helpers\FileHelper::normalizePath($fileSmallPath);

        if (file_exists($filePathFull)) {
            unlink($filePathFull);
        }
        $original = ArrayHelper::getValue($field, 'widget.1.options.original', false);
        if (is_array($original)) {
            self::resize($fileModel->tempName, $original);
        }

        if (!$fileModel->saveAs($filePathFull)) {
            return [
                $fieldName => ''
            ];
        }
        $small = ArrayHelper::getValue($field, 'widget.1.options.small', false);
        if ($small === false) {
            return [
                $fieldName => $filePath
            ];
        }
        $widthMax = 1;
        $heightMax = 1;
        if (is_numeric($small)) {
            // Обрезать квадрат
            $widthMax = $small;
            $heightMax = $small;
        }
        else if (is_array($small)) {
            $widthMax = $small[0];
            $heightMax = $small[1];
        }
        $quality = ArrayHelper::getValue($field, 'widget.1.options.quality', 80);
        $mode = ArrayHelper::getValue($field, 'widget.1.options.small.2', self::MODE_THUMBNAIL_INSET);
        $options = ['quality' => $quality];
        // generate a thumbnail image
        Image::thumbnail($filePathFull, $widthMax, $heightMax, $mode)->save($fileSmallPath, $options);

        return [
            $fieldName => $fileSmall
        ];
    }

    /**
     * Сжимает файл до макимальных размеров пропорционально
     *
     * @param string    $path
     * @param int|array $widthMax
     * @param int|null  $heightMax
     */
    private static function resize($path, $widthMax, $heightMax = null)
    {
        if (is_null($heightMax)) {
            if (is_array($widthMax)) {
                $heightMax = $widthMax[1];
                $widthMax = $widthMax[0];
            }
        }
        $size = Image::getImagine()->open($path)->getSize();
        $width = $size->getWidth();
        $height = $size->getHeight();
        // надо сжать
        if ($width > $widthMax && $height > $heightMax) {
            $widthNew = 1;
            $heightNew = 1;
            //Image::thumbnail($path, $widthNew, $heightNew)->save($path);
        }
    }

    /**
     * Преобразует путь превью в путь к оригинальной картинке
     *
     * @param string $small путь превью относительно корня сайта например /upload/users/00000026/small/avatar.jpg
     *
     * @return string
     */
    public static function getOriginal($small, $isLocalPath = true)
    {
        if ($small == '') return '';
        if (!$isLocalPath) {
            $info = parse_url($small);
            $small = $info['path'];
            $original = substr($small, 0, 23) . 'original' . substr($small, 28);

            return $info['scheme'] . '://' . $info['host'] . $original;
        }

        return substr($small, 0, 23) . 'original' . substr($small, 28);
    }

    public static function isSmall($path)
    {
        return (substr($path, 23, 5) == 'small');
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
        $fieldName = $field[ \cs\base\BaseForm::POS_DB_NAME ];
        $small = $model->$fieldName;
        $original = self::getOriginal($small);
        $serverName = ArrayHelper::getValue($field, 'type.1.serverName', '');

        return Html::a(Html::img($serverName . $small), $serverName . $original, ['target' => '_blank']);
    }
}
