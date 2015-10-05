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
        $body = file_get_contents($url);

        try {
            $doc = str_get_html($body);
        } catch (\Exception $e) {
            return null;
        }

        return $doc;
    }
} 