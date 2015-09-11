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
 * Class RonnaStar
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\RonnaStar('http://www.ronnastar.com/translations-index/russian-index/940-russian-08-2015.html'))->extract();
 * ```
 */
class RonnaStar extends Base implements ExtractorInterface
{
    /** @var  string */
    private $image;

    /** @var  \simple_html_dom */
    private $document;

    /** @var  string */
    private $content;

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
        $content = $this->getDocument()->find('div.rt-article/.module-content')[0];
        $p = $content->find('p')[1];
        $ret = [];
        foreach($p->nodes as $item) {
            if ($item->tag == 'text') {
                $ret[] = Html::tag('p', trim($item->plaintext));
            }
        }
        $ret[] = Html::tag('p', $content->find('p')[0]->plaintext);

        return join("\n", $ret);
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
        $h4 = $this->getDocument()->find('div.rt-article/.module-content/h4')[0];
        $name = $h4->plaintext;
        if (Str::sub($name,0,1) == '«') {
            $name = Str::sub($name,1);
        }
        if (Str::sub($name, Str::length($name) - 1, 1) == '»') {
            $name = Str::sub($name, 0, Str::length($name) - 1);
        }
        $name = Str::sub($name,0,1) . Str::toLower(Str::sub($name,1));

        return $name;
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
        return null;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return GsssHtml::getMiniText($this->getContent());
    }

} 