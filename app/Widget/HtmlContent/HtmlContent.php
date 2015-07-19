<?php

namespace cs\Widget\HtmlContent;

use cs\services\Security;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\debug\models\search\Debug;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use cs\base\BaseForm;
use cs\services\UploadFolderDispatcher;
use cs\services\SitePath;
use yii\helpers\StringHelper;
use yii\jui\InputWidget;

/**
 * Класс HtmlContent
 *
 */
class HtmlContent extends InputWidget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    public static $uploadFolder = 'HtmlContent';

    /** @var int $quality качество изображения */
    public static $quality = 100;

    public $uploadUrl = '/upload/HtmlContent2';

    private $fieldId;
    private $fieldName;

    public static $resizeBox = [
        1200,
        1200
    ];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        $this->fieldId = strtolower($this->model->formName() . '-' . $this->attribute);
        $this->fieldName = $this->model->formName() . '[' . $this->attribute . ']';
    }

    /**
     * рисует виджет
     */
    public function run()
    {
        $this->registerClientScript();
        $attribute = $this->attribute;
        $value = $this->model->$attribute;

        return Html::textarea($this->fieldName, $value, ['id' => $this->fieldId]);
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        \cs\Widget\HtmlContent\Asset::register($this->view);
        $js = <<<JS
        CKEDITOR.config.filebrowserUploadUrl = '{$this->uploadUrl}';
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.disallowedContent = true;
        CKEDITOR.replace( '{$this->fieldId}' );
JS;
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
        ];
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
        $content = $model->$fieldName;
        $destination = UploadFolderDispatcher::createFolder('HtmlContent', $model->getTableName(), $fieldName, $model->id);
        $content = self::process($content, $destination);

        return [
            $fieldName => $content,
        ];
    }

    /**
     * Удаляет
     *
     * @param \cs\base\BaseForm | \cs\base\DbRecord $model
     * @param array                                 $field
     *
     * @return string
     */
    public static function onDelete($field, $model)
    {
        self::getContentPath($field, $model)->delete();
    }


    /**
     * @param \cs\base\BaseForm | \cs\base\DbRecord $model
     * @param array                                 $field
     *
     * @return SitePath
     */
    private static function getContentPath($field, $model)
    {
        $fieldName = $field[ BaseForm::POS_DB_NAME ];

        return UploadFolderDispatcher::createFolder($model->getTableName(), $model->id, $fieldName);
    }


    /**
     * Выбирает все картинки копирует в папку назначения заменяет в $content и возвращает
     * и фильтрует на ненужные теги и атрибуты
     *
     * @param \simple_html_dom | string $content     контент
     * @param SitePath | string         $destination путь к папке назначения, она должна существовать
     *
     * @return string
     */
    public static function process($content, $destination)
    {
        if (!$content instanceof \simple_html_dom) {
            if ($content == '') return '';
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $content = str_get_html($content);
        };
        $content = self::filter($content);

        return self::copyImages($content, $destination);
    }

    /**
     * Выбирает все картинки копирует в папку назначения заменяет в $content и возвращает
     *
     * @param \simple_html_dom | string $content     контент
     * @param SitePath | string         $destination путь к папке назначения, она должна существовать
     *
     * @return string
     */
    public static function copyImages($content, $destination)
    {
        if ($content == '') return '';
        if (!$content instanceof \simple_html_dom) {
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $content = str_get_html($content);
        }

        foreach ($content->find('img') as $element) {
            $imagePath = new SitePath($element->attr['src']);

            // картинка не содержит путь назначения?
            if (!Str::isContain($element->attr['src'], $destination->getPath())) {
                $urlInfo = parse_url($element->attr['src']);
                if (ArrayHelper::getValue($urlInfo, 'scheme', '') == '') {
                    try {
                        $destinationFile = $destination->cloneObject()->add($imagePath->getFileName());
                        self::resizeImage($imagePath->getPathFull(), $destinationFile->getPathFull());
                        $element->attr['src'] = $destinationFile->getPath();
                    } catch (\Exception $e) {
                        Yii::warning($e->getMessage(), 'gs\\HtmlContent\\copyImages');
                    }
                } else {
                    // картинка на внешнем сервере, пока ничего не делаем
                }
            }
        }

        return $content->root->outertext();
    }

    /**
     * @param string $sourcePathFull      путь источника, должен быть локальным и полным
     * @param string $destinationPathFull путь назначения, должен быть локальным и полным
     */
    public static function resizeImage($sourcePathFull, $destinationPathFull)
    {
        $imagine = new \Imagine\Gd\Imagine();
        $size = new \Imagine\Image\Box(static::$resizeBox[0], static::$resizeBox[1]);
        $mode = \Imagine\Image\ImageInterface::THUMBNAIL_INSET;
        $imagine->open($sourcePathFull)->thumbnail($size, $mode)->save($destinationPathFull, ['quality' => self::$quality]);
    }

    /**
     * Убирает теги
     * script,
     * meta,
     * iframe и
     * аттрибуты событий начинающиеся на on и
     * аттрибут href для ссылки a если он начинается на javascript
     *
     * @param \simple_html_dom | string $content
     *
     * @return \simple_html_dom
     */
    public static function filter($content)
    {
        if (!$content instanceof \simple_html_dom) {
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $content = str_get_html($content);
        }
        foreach ($content->find('*') as $element) {
            foreach ($element->attr as $k => $v) {
                if (StringHelper::startsWith($k, 'on')) {
                    unset($element->attr[ $k ]);
                }
            }
        }
        // script
        foreach ($content->find('script') as $element) {
            foreach ($element->nodes as $node) {
                $node->_ = [];
            }
        }
        // a href="javascript: ... "
        // удаляю аттрибут
        foreach ($content->find('a') as $element) {
            foreach ($element->nodes as $node) {
                if (isset($element->attr['href'])) {
                    $href = $element->attr['href'];
                    if (StringHelper::startsWith($href, 'javascript')) {
                        unset($element->attr['href']);
                    }
                }
            }
        }
        // meta
        // удаляю все атрибуты и подноды
        foreach ($content->find('meta') as $element) {
            $element->attr = [];
            foreach ($element->nodes as $node) {
                $node->_ = [];
            }
        }

        return $content;
    }

}
