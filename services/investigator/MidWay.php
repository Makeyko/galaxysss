<?php

namespace app\services\investigator;


use app\models\Investigator;
use app\services\GetArticle\Chenneling;
use cs\services\Str;
use cs\services\VarDumper;
use yii\helpers\StringHelper;

class MidWay extends Base implements InvestigatorInterface
{
    /** @var string ссылка где публикуются обновления */
    public $url = 'https://vk.com/wall-84190266';

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
        foreach ($doc->find('.wall_item') as $div) {
            if ($c > 1) {
                $url = 'https://vk.com' . $div->find('.wi_date')[0]->attr['href'];
                $html = $div->find('.pi_text')[0];
                $header = explode('..............................', $html->plaintext);
                $header = trim($header[0]);
                if (StringHelper::endsWith($header, '.')) {
                    $header = Str::sub($header, 0, Str::length($header) - 1);
                }
                $header = Str::toLower($header);
                $first = Str::toUpper(Str::sub($header,0,1));
                $header = $first . Str::sub($header,1);

                $ret[] = [
                    'name' => $header,
                    'url' => $url,
                ];
            }
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
        return new \app\services\GetArticle\VkMidway($url);
    }
} 