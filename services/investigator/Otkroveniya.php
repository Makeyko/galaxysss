<?php

namespace app\services\investigator;


class Otkroveniya extends Base implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://www.otkroveniya.ru/2015.html';
    public $serverName = 'http://www.otkroveniya.ru';

    /**
     * @return array
     * [[
     *     'name'
     *     'url'
     * ],...]
     */
    public function getItems()
    {
        $doc = $this->getDocument($this->url);

        $ret = [];
        foreach ($doc->find('#rcol/.cont/a') as $a) {
            $url = $this->serverName . $a->attr['href'];
            $name = $a->plaintext;

            $ret[] = [
                'name' => $name,
                'url'  => $url,
            ];
        }

        return $ret;
    }

    /**
     * Получает
     *
     * @param string $url
     *
     * @return \app\services\GetArticle\ExtractorInterface
     */
    public function getItem($url)
    {
        return new \app\services\GetArticle\Otkroveniya($url);
    }
} 