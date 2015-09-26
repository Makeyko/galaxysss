<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 10.09.2015
 * Time: 2:52
 */


namespace app\services\investigator;

use app\models\Investigator;

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
        $body = curl_exec($curl);

        $result = new \StdClass();
        $result->status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result->body = $body;
        curl_close($curl);

        if ($result->status_code != 200) {
            throw new \cs\web\Exception('Не удалось прочитать файл ' . $url);
        }

        try {
            $doc = str_get_html($body);
        } catch (\Exception $e) {
            return null;
        }

        return $doc;
    }
} 