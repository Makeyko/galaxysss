<?php

namespace cs\Widget\FileUpload2;

use cs\services\File;
use cs\services\SitePath;

use Imagine\Image\Box;
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
use cs\services\UploadFolderDispatcher;

/**
 *
 * ```php
 * $this->options = [
 *      'small'      => [
 *           300,
 *           300,
 *           FileUpload::MODE_THUMBNAIL_OUTBOUND
 *          'isExpandSmall' => true,
 *      ],
 *      'original'   => [
 *           3000,
 *           3000,
 *           FileUpload::MODE_THUMBNAIL_OUTBOUND
 *          'isExpandSmall' => true,
 *      ],
 *      'quality'    => 80,
 *      'folder'     => 'users',
 *      'serverName' => 'http://' . \cs\models\Client::getServerName(),
 * ]
 * ```
 *
 * `quality`    - integer - качество сохранения пережимаемых изображений
 * `folder`     - string - папка для сохранения файлов в папке upload, по умолчанию используется название таблицы
 *                формат /upload/FileUpload2/{folder}/[rowId]/ ...
 * `serverName` - string    - имя сервера на котором лежит картинка, используется для [[self::getOriginal()]] и  [[self::onDraw()]]
 * `small`      - array|int - если array, то первое формат [width, height, resizeOption]
 *                          `width`        - int - ширина
 *                          `height`       - int - высота
 *                          `resizeOption` - int - может быть следующих значений
 *                                               FileUpload::MODE_THUMBNAIL_INSET (с обрезкой, по умолчанию)
 *                                               FileUpload::MODE_THUMBNAIL_OUTBOUND (с полями)
 *                                               если не указано то используется значение по умолчанию (FileUpload::MODE_THUMBNAIL_INSET)
 *                          если int, то это число означает одновременно ширину и высоту и по умалчанию используется опция обрезки FileUpload::MODE_THUMBNAIL_INSET
 *                          `isExpandSmall`   - bool   - true - расширять картинку если она маленькая до размеров формата
 *                                                       false - недостающие области закрасить полями белыми
 * `original`   - array|int   - формат тот же что и для `small` и применяется для оригинальной картинки
 * `extended`   - array       - массив дополнительных форматов картинок
 * [
 *      'name' => format
 * ]
 * соответственно имя поля в бд будет {attribute}_{name}
 *
 * в разработке:
 * `isUseDbFieldForOriginal` - bool - если true то для оригинальной картинки будет использоваться дополнительное поле {attribute}_original
 *                                    то есть функция onUpdate будет возвращать два поля
 *
 */


class FileUpload extends InputWidget
{
    /** с обрезкой, по умолчанию */
    const MODE_THUMBNAIL_CUT    = ManipulatorInterface::THUMBNAIL_OUTBOUND;
    /** вписать */
    const MODE_THUMBNAIL_FIELDS = ManipulatorInterface::THUMBNAIL_INSET;

    /**
     * @var array опции виджета
     */
    public $options;

    /**
     * @var bool
     * если true то для оригинальной картинки будет использоваться дополнительное поле {attribute}_original,
     * то есть функция onUpdate будет возвращать два поля
     */
    public $isUseDbFieldForOriginal;

    private $fieldIdName;
    private $actionIdName;
    private $actionNameAttribute;
    private $isDeleteNameAttribute;
    private $isDeleteIdName;
    private $valueNameAttribute;
    private $valueIdName;

    private $attrId;
    private $attrName;

    public $widgetOptions;
    public $isExpandSmall = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->attrName = $this->model->formName() . '[' . $this->attribute . ']';
        $this->attrId = strtolower($this->model->formName() . '-' . $this->attribute);

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

            return $this->render('@csRoot/Widget/FileUpload2/FileUpload.tpl', [
                'value'         => $value,
                'original'      => self::getOriginal($value),
                'formName'      => $this->model->formName(),
                'model'         => $this->model,
                'attrId'        => $this->attrId,
                'attrName'      => $this->attrName,
                'widgetOptions' => $this->widgetOptions,
            ]);
        }
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $deleteCallback = <<<JSSS
FileUpload2.init('#{$this->attrId}');
JSSS;

        $this->getView()->registerJs($deleteCallback);
        Asset::register($this->getView());
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
     * @return bool
     */
    public static function onDelete($field, $model)
    {
        self::getFolderPath($field, $model)->delete();

        return true;
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

        if ($model->$fieldName == '') {
            return [
                $fieldName => ''
            ];
        }
        $fileModel = UploadedFile::getInstance($model, $fieldName);
        if (is_null($fileModel)) return [];
        if ($fileModel->error > 0) return [];

        return self::save(File::path($fileModel->tempName), $fileModel->extension, $field, $model);
    }

    /**
     * @param \cs\services\File $file
     * @param string            $extension
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return array
     */
    public static function save($file, $extension, $field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];
        $path = self::getFolderPath($field, $model);

        $folderSmall = $path->create('small');
        $folderOriginal = $path->create('original');
        $fileName = $fieldName . '.' . $extension;
        $folderSmall->add($fileName)->deleteFile();
        $folderOriginal->add($fileName)->deleteFile();

        $smallFormat = ArrayHelper::getValue($field, 'widget.1.options.small', false);
        $originalFormat = ArrayHelper::getValue($field, 'widget.1.options.original', false);
        self::saveImage($file, $folderOriginal, $originalFormat, $field);
        if ($smallFormat === false) {
            return [
                $fieldName => $folderOriginal->getPath()
            ];
        } else {
            self::saveImage(File::path($folderOriginal->getPathFull()), $folderSmall, $smallFormat, $field);

            return [
                $fieldName => $folderSmall->getPath()
            ];
        }

    }

    /**
     * Сохраняет картинку по формату
     *
     * @param \cs\services\File     $file
     * @param \cs\services\SitePath $destination
     * @param array $field
     * @param array | false $format => [
     *           3000,
     *           3000,
     *           FileUpload::MODE_THUMBNAIL_OUTBOUND
     *          'isExpandSmall' => true,
     *      ] ,
     *
     * @return \cs\services\SitePath
     */
    private static function saveImage($file, $destination, $format, $field)
    {
        if ($format === false || is_null($format)) {
            $file->save($destination->getPathFull());
            return $destination;
        }

        $widthFormat = 1;
        $heightFormat = 1;
        if (is_numeric($format)) {
            // Обрезать квадрат
            $widthFormat = $format;
            $heightFormat = $format;
        }
        else if (is_array($format)) {
            $widthFormat = $format[0];
            $heightFormat = $format[1];
        }

        // generate a thumbnail image
        $mode = ArrayHelper::getValue($format, 2, self::MODE_THUMBNAIL_CUT);
        if ($file->isContent()) {
            $image = Image::getImagine()->load($file->content);
        } else {
            $image = Image::getImagine()->open($file->path);
        }
        if (ArrayHelper::getValue($format, 'isExpandSmall', true)) {
            $image = self::expandImage($image, $widthFormat, $heightFormat, $mode);
        }
        $quality = ArrayHelper::getValue($field, 'widget.1.options.quality', 80);
        $options = ['quality' => $quality];
        $image->thumbnail(new Box($widthFormat, $heightFormat), $mode)->save($destination->getPathFull(), $options);

        return $destination;
    }

    /**
     * Расширяет маленькую картинку по заданной стратегии
     *
     * @param \Imagine\Image\ImageInterface $image
     * @param int $widthFormat
     * @param int $heightFormat
     * @param int $mode
     *
     * @return \Imagine\Image\ImageInterface
     */
    protected static function expandImage($image, $widthFormat, $heightFormat, $mode)
    {
        $size = $image->getSize();
        $width = $size->getWidth();
        $height = $size->getHeight();
        if ($width < $widthFormat || $height < $heightFormat) {
            // расширяю картинку
            if ($mode == self::MODE_THUMBNAIL_CUT) {
                if ($width < $widthFormat && $height >= $heightFormat) {
                    $size = $size->widen($widthFormat);
                } else if ($width >= $widthFormat && $height < $heightFormat) {
                    $size = $size->heighten($heightFormat);
                } else if ($width < $widthFormat && $height < $heightFormat) {
                    // определяю как расширять по ширине или по высоте
                    if ($width / $widthFormat < $height / $heightFormat) {
                        $size = $size->widen($widthFormat);
                    }
                    else {
                        $size = $size->heighten($heightFormat);
                    }
                }
                $image->resize($size);
            } else {
                if ($width < $widthFormat && $height >= $heightFormat) {
                    $size = $size->heighten($heightFormat);
                } else if ($width >= $widthFormat && $height < $heightFormat) {
                    $size = $size->widen($widthFormat);
                } else if ($width < $widthFormat && $height < $heightFormat) {
                    // определяю как расширять по ширине или по высоте
                    if ($width / $widthFormat < $height / $heightFormat) {
                        $size = $size->heighten($heightFormat);
                    }
                    else {
                        $size = $size->widen($widthFormat);
                    }
                }
                $image->resize($size);
            }
        }

        return $image;
    }

    /**
     * Создает папку для загрузки
     *
     * @param array             $field
     * @param \cs\base\BaseForm $model
     *
     * @return \cs\services\SitePath
     */
    protected static function getFolderPath($field, $model)
    {
        $folder = ArrayHelper::getValue($field, 'type.1.folder', $model->getTableName());

        return UploadFolderDispatcher::createFolder('FileUpload2', $folder, $model->id);
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
            $original = self::getOriginalLocal($info['path']);

            return $info['scheme'] . '://' . $info['host'] . $original;
        }

        return self::getOriginalLocal($small);
    }

    /**
     * Возвращает ссылку на оригинальный файл относительно корня сайта
     *
     * @param $path
     *
     * @return string
     */
    private static function getOriginalLocal($path)
    {
        $path = ltrim($path, '/');
        $arr = explode('/', $path);

        return '/' . $arr[0] . '/' . $arr[1] . '/' . $arr[2] . '/' . $arr[3] . '/' . 'original' . '/' . $arr[5];
    }

    /**
     *
     * @param $path
     *
     * @return bool
     */
    public static function isSmall($path)
    {
        $path = rtrim($path, '/');
        $arr = explode('/', $path);

        return $arr[4] == 'small';
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
        if ($small == '') return '';
        $original = self::getOriginal($small);
        $serverName = ArrayHelper::getValue($field, 'widget.1.options.serverName', '');
        if ($serverName != '') {
            $small = $serverName . $small;
            $original = $serverName . $original;
        }

        return Html::a(Html::img($small), $original, ['target' => '_blank']);
    }
}
