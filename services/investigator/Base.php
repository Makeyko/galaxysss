<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 10.09.2015
 * Time: 2:52
 */

namespace app\services\investigator;


class Base
{
    /**
     * Возвращает разобранный документ
     *
     * @param string $url
     *
     * @return bool|\simple_html_dom
     */
    public function getDocument($url)
    {
        require_once(\Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));

        return file_get_html($url);
    }
} 