<?php

namespace app\services\GetArticle;

use cs\services\Url;
use cs\services\VarDumper;
use Yii;
use yii\base\ExitException;
use yii\base\Object;
use yii\helpers\Html;
use cs\services\Security;
use yii\helpers\StringHelper;
use cs\services\Str;

/**
 * Class YouTube
 * @package app\services\GetArticle
 *
 * ```php
 * $array = (new \app\services\GetArticle\YouTube([
 *     'url' => 'http://www.youtube.com/watch?v=w3EEUhnNf08'
 * ]))->run();
 * ```
 *
 * YouTube Api
 * https://developers.google.com/youtube/v3/
 */
class YouTube implements ExtractorInterface
{
    /** @var  string */
    public $url;

    /** @var  string идентификатор видео YouTube */
    public $idString;

    /** @var  \DOMDocument */
    public $document;

    public function __construct($url)
    {
        $this->url = $url;
        $urlObject = new Url($url);
        if ($urlObject->host == 'www.youtube.com') {
            $this->idString = $urlObject->getParam('v');
            return;
        }
        if ($urlObject->host == 'youtu.be') {
            $this->idString = ltrim($urlObject->path, '/');
            return;
        }
        throw new ExitException('Ссылку можно использовать только youtube.com, youtu.be');
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
            'image'   => $this->getImage(),
            'header'  => $this->getHeader(),
            'content' => $this->getContent(),
        ];
    }

    public function html()
    {
        return $this->getContent();
    }

    public function getContent()
    {
        return '<iframe width="640" height="360" src="https://www.youtube.com/embed/'.$this->idString.'" frameborder="0" allowfullscreen></iframe>';
    }

    /**
     * Возвращает название статьи
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->getDocument()->getElementsByTagName("title")->item(0)->nodeValue;
    }

    private function getDocument()
    {
        if (is_null($this->document)) {
            $url = 'http://gdata.youtube.com/feeds/api/videos/'. $this->idString;
            $doc = new \DOMDocument;
            $doc->load($url);
            $this->document = $doc;
        }

        return $this->document;
    }

    /**
     * Возвращает картинку для статьи
     * Если картинки нет то будет возвращено null
     *
     * @return string | null
     */
    public function getImage()
    {
        return "http://img.youtube.com/vi/{$this->idString}/0.jpg";
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return '';
    }

} 