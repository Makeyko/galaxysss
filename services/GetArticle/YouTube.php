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
class YouTube extends Base implements ExtractorInterface
{
    /** @var  string идентификатор видео YouTube */
    public $idString;

    /**
     * @var  \stdClass $document
     * @see http://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=pdjU7Ao2itE&format=json
     */
    public $document;

    public function __construct($url)
    {
        parent::__construct($url);
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
        return '<iframe width="640" height="360" src="https://www.youtube.com/embed/' . $this->idString . '" frameborder="0" allowfullscreen></iframe>';
    }

    /**
     * Возвращает название статьи
     *
     * @return string
     */
    public function getHeader()
    {
        return $this->getDocument()->title;
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
     * Возвращает информацио о видео
     *
     * @return \stdClass
    {
     * "provider_url": "http://www.youtube.com/",
     * "title": "СБОРНИК НЕПРЕРЫВНОГО СМЕХА  Игорь Маменко Новое 2015 года",
     * "thumbnail_url": "https://i.ytimg.com/vi/pdjU7Ao2itE/hqdefault.jpg",
     * "thumbnail_width": 480,
     * "author_name": "ЮМОР И СМЕХ",
     * "height": 344,
     * "version": "1.0",
     * "thumbnail_height": 360,
     * "width": 459,
     * "author_url": "http://www.youtube.com/channel/UCXQtFaBlKQk2GtUzBRMpqsg",
     * "provider_name": "YouTube",
     * "html": "<iframe width=\"459\" height=\"344\" src=\"https://www.youtube.com/embed/pdjU7Ao2itE?feature=oembed\" frameborder=\"0\" allowfullscreen></iframe>",
     * "type": "video"
     * }
     */
    public function getDocument()
    {
        if (is_null($this->document)) {
            $data = file_get_contents((new Url('http://www.youtube.com/oembed'))->addParam('url', $this->url)->addParam('format', 'json'));
            $this->document = json_decode($data);
        }

        return $this->document;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getDocument()->title;
    }

} 