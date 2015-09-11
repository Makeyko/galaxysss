<?php

namespace app\services\investigator;


use app\models\Investigator;
use app\services\GetArticle\Chenneling;
use cs\services\VarDumper;

class SiteChennelingNet extends Base implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://chenneling.net/tag/poslanie-salusa-s-siriusa';

    /** @var int идентификатор фильтра в таблице gs_channeling_investigator */
    public $id = 1;

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
        foreach($doc->find('div.art-content/div.art-post') as $div) {
            if ($c > 1) {
                $a = $div->find('div.art-article/h2/a');
                try {
                    $name = trim($a[0]->plaintext);
                    $url = $a[0]->attr['href'];
                } catch (\Exception $e) {
                    continue;

                }
                $ret[] = [
                    'name' => $name,
                    'url'  => $url,
                ];
            }
            $c++;
        }

        return $ret;
    }

    /**
     * Возвращает новые элементы
     *
     * @return array
     * [[
     *     'name'
     *     'url'
     * ],...]
     */
    public function getNewItems()
    {
        $class_name = get_called_class();
        $items = $this->getItems();
        $dbItems = Investigator::query(['class_name' => $class_name])->select('url')->column();
        $ret = [];
        foreach($items as $item) {
            if (!in_array($item['url'], $dbItems)) {
                $ret[] = $item;
            }
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
        return new Chenneling($url);
    }
} 