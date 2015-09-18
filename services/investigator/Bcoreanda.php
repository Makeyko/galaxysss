<?php

namespace app\services\investigator;


use app\models\Investigator;
use app\services\GetArticle\Chenneling;
use cs\services\VarDumper;

class Bcoreanda extends SiteChennelingNet implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://bcoreanda.com/BrowseArt.aspx?CatID=35';

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
        $c = 1;
        foreach($doc->find('#ctl00_MainContent_ArticleListing1_gvwArticles/div.articlebox') as $div) {
            $a = $div->find('div.articletitle/a');
            try {
                $name = trim($a[0]->plaintext);
                $url = 'http://bcoreanda.com/' . $a[0]->attr['href'];
            } catch (\Exception $e) {
                continue;
            }
            $ret[] = [
                'name' => $name,
                'url'  => $url,
            ];
            $c++;
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
        return new \app\services\GetArticle\Bcoreanda($url);
    }
}