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
class VkMidway extends Base implements ExtractorInterface
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
        VarDumper::dump([
            'image'       => $this->getImage(),
            'header'      => $this->getHeader(),
            'content'     => $this->getContent(),
            'description' => $this->getDescription(),
        ]);
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
        $html = $this->getObjArticle();
        $header = explode('..............................', $html->plaintext);
        $header = $header[count($header) -1];
        // ищу начало текста
        $i = 0;
        foreach(Str::getChars($header) as $item) {
            if ($item == '.') {
                $i++;
                continue;
            } else {
                break;
            }
        }
        $header = trim(Str::sub($header, $i));
        $strings = $this->getProposal($header);
        $pArray = $this->unionStrings($strings, 1000);
        $new = [];
        foreach($pArray as $p) {
            $new[] = Html::tag('p', $p);
        }

        return join("\n", $new);
    }

    /**
     * Объединяет предложения в параграфы
     *
     * @param array $strings предложения
     * @param integer $lengthParagraph максимальная длина параграфа
     *
     * @return array параграфы
     */
    private function unionStrings($strings, $lengthParagraph)
    {
        $p = []; // один текущий параграф
        $c = 0; // длина текущего параграфа
        $arr = []; // все параграфы
        for($i = 0; $i <count($strings); $i++) {
            $s = $strings[ $i ]; // текущее предложение
            $len = Str::length($s); // длина текущей строки
            $lenTest = $c + $len + 1; // длина предполагаемого абзаца
            if ($lenTest > $lengthParagraph) {
                $arr[] = join(' ', $p);
                $p = [$s];
                $c = $len;
            } else if ($lenTest == $lengthParagraph) {
                $p[] = $s;
                $arr[] = join(' ', $p);
                $p = [];
                $c = 0;
            } else {
                $p[] = $s;
                $c = $lenTest;
            }
        }
        if (count($p) > 0) {
            $arr[] = join(' ', $p);
        }

        return $arr;
    }

    /**
     * Получить предложения из текста
     *
     * @param $text
     *
     * @return array
     */
    private function getProposal($text)
    {
        $text = str_replace("\n", " ", $text);
        $text = str_replace("\r", " ", $text);
        $text = explode(" ", $text);
        $i = 0; // индекс сквозной указывающий на текущий обрабатываемый элемент
        $strings = []; // предложения
        $string = []; // текущее предложение
        $isStringEnd = false; // указатель что в прошлой итерации было слово с точкой
        for ($i = 0; $i < count($text); $i++) {
            $word = $text[$i];
            if ($word == '') continue;
            if ($isStringEnd) {
                if (Str::isUpper(Str::sub($word, 0, 1))) {
                    $strings[] = join(' ', $string);
                    $string = [];
                    $string[] = $word;
                } else {
                    $string[] = $word;
                }
                $isStringEnd = false;
            } else {
                // если слово окончивается на точку, то ставим флаг $isStringEnd
                if (Str::sub($word, Str::length($word)-1) == '.') {
                    $isStringEnd = true;
                }
                $string[] = $word;
            }
        }
        $strings[] = join(' ', $string);

        return $strings;
    }

    /**
     * Возвращает объект статьи
     *
     * @return \simple_html_dom_node
     */
    public function getObjArticle()
    {
        if (is_null($this->article)) {
            $r = $this->getDocument()->find('.wi_body');
            if (count($r) == 0) {
                $r = $this->getDocument()->find('#wrap1/.wall_post_text');
            }
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
        $header = explode('..............................', $html->plaintext);
        $header = trim($header[0]);
        if (StringHelper::endsWith($header, '.')) {
            $header = Str::sub($header, 0, Str::length($header) - 1);
        }
        $header = Str::toLower($header);
        $first = Str::toUpper(Str::sub($header,0,1));
        $header = $first . Str::sub($header,1);

        return $header;
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