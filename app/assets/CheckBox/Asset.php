<?php

/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace cs\assets\CheckBox;

use yii\web\AssetBundle;
use Yii;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@csRoot/assets/CheckBox/source';
    public $css      = [
        'css/bootstrap-toggle.min.css',
    ];
    public $js       = [
        'js/bootstrap-toggle.min.js'
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
