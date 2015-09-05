<?php

namespace app\services\GetArticle;

use cs\services\VarDumper;
use Yii;
use yii\base\Object;
use yii\helpers\Html;
use cs\services\Security;
use yii\helpers\StringHelper;
use cs\services\Str;
use app\services\GsssHtml;

/**
 * Class VkMidway
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\VkMidway('https://vk.com/wall-84190266_337'))->extract();
 * ```
 */
class Tasachena implements ExtractorInterface
{
    /** @var  string */
    public $url;

    /** @var  string */
    private $image;

    /** @var  \simple_html_dom */
    private $document;

    /** @var  string */
    private $content;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Возвращает информацию о статье
     *
     * @return array
     * [
     *     'image'   => $this->getImage(),
     *     'header'  => $this->getHeader(),
     *     'content' => $this->getContent(),
     * ];
     */
    public function extract()
    {
        return [
            'image'       => $this->getImage(),
            'header'      => $this->getHeader(),
            'content'     => $this->getContent(),
            'description' => $this->getDescription(),
        ];
    }

    public function html()
    {
        return $this->getContent();
    }

    public function getContent()
    {
        if (is_null($this->content)) {
            $this->content = $this->_getContent();
        }

        return $this->content;
    }

    public function _getContent()
    {
        $html = $this->getDocument()->find('article/div.item-content')[0];

        $arr = [];
        $arr[] = Html::tag('p', Html::img($this->getImage(), [
            'width' => '100%',
            'class' => 'thumbnail',
        ]));
        foreach ($html->find('*') as $item) {
            if ($item instanceof \simple_html_dom_node) {
                if ($item->tag == 'div') {
                    if (strpos($item->attr['class'], 'essb_links') !== false) {
                        break;
                    }
                }
                $arr[] = $item->outertext();
            }
        }

        return join("\n", $arr);
    }

    public function getDocument()
    {
        if (is_null($this->document)) {
            $url = $this->url;
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $this->document = file_get_html($url);
        }

        return $this->document;
    }

    /**
     * Возвращает название статьи
     *
     * @return string
     */
    public function getHeader()
    {
        $a = $this->getDocument()->find('div.blog-heading/h1');

        return $a[0]->plaintext;
    }

    /**
     * Возвращает картинку для статьи
     * Если картинки нет то будет возвращено null
     *
     * @return string | null
     */
    public function _getImage()
    {
        $a = $this->getDocument()->find('div#body')[0];
        $a = $a->find('div#post-thumb')[0];
        $a = $a->find('img');

        return $a[0]->attr['src'];
    }

    /**
     * Возвращает картинку для статьи
     * Если картинки нет то будет возвращено null
     *
     * @return string | null
     */
    public function getImage()
    {
        if (is_null($this->image)) {
            $this->image = $this->_getImage();
        }

        return $this->image;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return GsssHtml::getMiniText($this->getContent());
    }

} 