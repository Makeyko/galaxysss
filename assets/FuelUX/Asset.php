<?php

/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets\FuelUX;

use yii\web\AssetBundle;
use Yii;

/**
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@vendor/ExactTarget/fuelux/dist';
    public $css      = [
        'css/fuelux.min.css',
    ];
    public $js       = [
        'js/fuelux.min.js'
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
