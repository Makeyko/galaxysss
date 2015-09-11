<?php

namespace app\services\investigator;


use app\models\Investigator;
use app\services\GetArticle\Chenneling;
use cs\services\Str;
use cs\services\VarDumper;
use yii\helpers\StringHelper;

class RonnaStar extends Base implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'http://www.ronnastar.com/translations-index/russian-index.html';

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
        foreach ($doc->find('.rt-leading-articles/.rt-article') as $div) {
            $a = $div->find('.module-title/a')[0];
            $url = 'http://www.ronnastar.com' . $a->attr['href'];
            $h4 = $div->find('.module-content/h4')[0];
            $name = $h4->plaintext;
            if (Str::sub($name,0,1) == '«') {
                $name = Str::sub($name,1);
            }
            if (Str::sub($name, Str::length($name) - 1, 1) == '»') {
                $name = Str::sub($name, 0, Str::length($name) - 1);
            }
            $name = Str::sub($name,0,1) . Str::toLower(Str::sub($name,1));

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
        return new \app\services\GetArticle\RonnaStar($url);
    }
} 