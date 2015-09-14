<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\HumanDesign\widget\PlaceMap;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@app/modules/HumanDesign/widget/PlaceMap/assets';
    public $css = [
        'default.css',
    ];
    public $js = [
        'handlers.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'cs\assets\GoogleMaps',
    ];
}
