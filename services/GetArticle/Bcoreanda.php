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
 * Class Bcoreanda
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\Bcoreanda('http://chenneling.net/chennelingi/poslanie-salusa-s-siriusa-ot-4-sentyabrya-2015-goda.html'))->extract();
 * ```
 */
class Bcoreanda extends Base implements ExtractorInterface
{
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
        $html = $this->getDocument()->find('div.sectiontext');

        $arr = [];
        foreach ($html[0]->find('*') as $item) {
            if (($item->tag != 'text') and ($item->tag != 'h1')) {
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
        $a = $this->getDocument()->find('div.sectiontext/h1');

        return trim($a[0]->plaintext);
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