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
 * Class Verhosvet
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\Verhosvet('http://verhosvet.org/2015/05/poslanie-arkturianskoj-gruppy-ot-10-maya-2015-goda/'))->extract();
 * ```
 */
class Verhosvet implements ExtractorInterface
{
    /** @var  string */
    public $url;

    /** @var  \simple_html_dom_node */
    private $article;

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
            $arr = $this->getContentAsArray();
            $ret = [];
            foreach ($arr as $item) {
                if (StringHelper::endsWith($item, "\n")) {
                    $item = Str::sub($item, 0, Str::length($item) - 1);
                }
                if (StringHelper::endsWith($item, "\r")) {
                    $item = Str::sub($item, 0, Str::length($item) - 1);
                }
                $ret[] = Html::tag('p', $item);
            }

            $this->content = join("\r\n", $ret);
        }

        return $this->content;
    }

    /**
     * Возвращает массив чистых строк без тегов
     *
     * @return array
     */
    public function getContentAsArray()
    {
        $html = $this->getObjArticle();
        $ret = [];
        foreach ($html->find('div.td-post-text-content/p') as $p) {
            if ($p instanceof \simple_html_dom_node) {
                if ($p->children[0]->tag != 'noindex') {
                    $string = trim($p->plaintext);
                    if (StringHelper::startsWith($string, '&nbsp;')) {
                        $string = Str::sub($string, 6);
                    }
                    $ret[] = $string;
                }
            }
        }

        return $ret;
    }

    /**
     * Возвращает объект статьи
     *
     * @return \simple_html_dom_node
     */
    public function getObjArticle()
    {
        if (is_null($this->article)) {
            $this->article = $this->getDocument()->find('article')[0];
        }

        return $this->article;
    }

    public function getDocument()
    {
        if (is_null($this->document)) {
            $url = $this->url;
            require_once(Yii::getAlias('@vendor/simplehtmldom_1_5/simple_html_dom.php'));
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
        $html = $this->getObjArticle();

        return $html->find('header/h1')[0]->plaintext;
    }

    /**
     * Возвращает картинку для статьи
     * Если картинки нет то будет возвращено null
     *
     * @return string | null
     */
    public function getImage()
    {
        $meta = $this->getDocument()->find('html/head/meta[property="og:image"]');
        if (is_null($meta)) return null;
        $image = $meta[0]->attr['content'];

        return $image;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return GsssHtml::getMiniText($this->getContent());
    }

} 