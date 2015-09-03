<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace cs\Widget;

use cs\services\VarDumper;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\FormatConverter;
use yii\helpers\Html;
use yii\helpers\Json;
use cs\assets\ClearJuiJsAsset as JuiAsset;



class CountDown
{
    /**
     * @param $selector
     * @param string|int|\DateTime $date
     */
    public static function register($selector, $date)
    {
        $dt = self::convertDate($date);
        $asset = \cs\assets\CountDownAsset::register(Yii::$app->view);
        $js = <<<JSON_U
            $('{$selector}').countdown({
                        stepTime: 60,
                        format: 'ddдн. hhч. mmм. ssс.',
                        digitImages: 6,
                        digitHeight: 45,
                        digitWidth: 34,
                        endTime: new Date({$dt}),
                        image: "{$asset->baseUrl}/img/digits05.png"
                    });
JSON_U;
        \Yii::$app->view->registerJs(new \yii\web\JsExpression($js));
    }

    /**
     * @param string|int|\DateTime $date UTC
     *
     * @return integer - unix time
     */
    private static function convertDate($date)
    {
        if (is_string($date)) {
            return (int)(new \DateTime($date, new \DateTimeZone('UTC')))->format('U');
        } else if ($date instanceof DateTime) {
            return (int)$date->format('U');
        } else if (is_integer($date)) {
            return $date;
        } else {
            return null;
        }
    }
}
