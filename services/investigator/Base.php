<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 10.09.2015
 * Time: 2:52
 */


namespace app\services\investigator;

use app\models\Investigator;
use cs\services\Url;
use cs\services\VarDumper;
use yii\helpers\ArrayHelper;

class Base
{
    public function className()
    {
        return get_called_class();
    }


    /**
     * @return array
     * [[
     *     'name'
     *     'url'
     * ],...]
     */
    public function getItems()
    {

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

        $dbItems = Investigator::query([
                'class_name' => $class_name,
            ])
            ->andWhere(['in', 'status', [1, 2]])
            ->select('url')
            ->column()
        ;
        $ret = [];
        foreach($items as $item) {
            if (!in_array($item['url'], $dbItems)) {
                $ret[] = $item;
            }
        }

        return $ret;
    }

    /**
     * Возвращает разобранный документ
     *
     * @param string $url
     *
     * @return bool|\simple_html_dom
     * @throws \cs\web\Exception
     */
    public function getDocument($url)
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        $body = curl_exec($curl);

        $result = new \StdClass();
        $result->headers = curl_getinfo($curl);
        $result->body = $body;
        curl_close($curl);
        if ($result->headers['http_code'] != 200) {
            throw new \cs\web\Exception('Не удалось прочитать файл');
        }
        $temp = explode(';',$result->headers['content_type']);
        if (count($temp) == 1) {
            // в заголовке не указана кодировка, определяю ее через документ
            $pos = strpos($body, 'text/html; charset=');
            $openQuote = substr($body, $pos-1, 1);
            $endPos = strpos($body, $openQuote, $pos);
            $content_type = substr($body, $pos, $endPos-$pos);
            $temp = explode(';', $content_type);
        }
        $temp = trim($temp[1]);
        $temp = explode('=', $temp);
        $charset = $temp[1];
        if ($charset == 'windows-1251') {
            $body = mb_convert_encoding($body, 'UTF-8', 'WINDOWS-1251');
        }

        try {
            $doc = str_get_html($body);
        } catch (\Exception $e) {
            return null;
        }

        return $doc;
    }
} 