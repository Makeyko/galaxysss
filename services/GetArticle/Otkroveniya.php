<?php

namespace app\services\GetArticle;

use Yii;
use yii\helpers\Html;
use app\services\GsssHtml;

/**
 * Class Otkroveniya
 *
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\Otkroveniya('https://vk.com/wall-84190266_337'))->extract();
 * ```
 */
class Otkroveniya extends Base implements ExtractorInterface
{
    /** @var  \simple_html_dom */
    private $article;

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
            'date'        => $this->getDate(),
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
        $html = $this->getObjArticle();
        $ret = [];
        foreach ($html->find('p') as $node) {
            $ret[] = Html::tag('p', $node->plaintext);
        }

        return join("\n", $ret);
    }

    /**
     * Возвращает объект статьи
     *
     * @return \simple_html_dom_node
     */
    public function getObjArticle()
    {
        if (is_null($this->article)) {
            $r = $this->getDocument()->find('#rcol');
            $this->article = $r[0];
        }

        return $this->article;
    }

    public function getDocument()
    {
        if (is_null($this->document)) {
            $this->document = $this->_getDocument();
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
        $d1 = $html->find('h1')[0];
        $result = null;
        foreach ($d1->nodes as $node) {
            if ($node->tag == 'text') {
                return $node->plaintext;
            }
        }

        return '';
    }

    /**
     * Возвращает дату послания
     *
     * @return string 'yyyy-mm-dd'
     */
    public function getDate()
    {
        $html = $this->getObjArticle();
        $d1 = $html->find('h1/.date')[0];
        $date = $d1->plaintext;
        $date = '20' . substr($date, 6, 2) . '-' . substr($date, 3, 2) . '-' . substr($date, 0, 2);

        return $date;
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