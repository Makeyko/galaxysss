<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\helpers\VarDumper;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class GoSamples extends AssetBundle
{
    public $sourcePath = '@vendor/NorthwoodsSoftware/GoJS';
    public $css      = [
        'assets/css/highlight.css',
        'assets/css/goSamples.css',
    ];
    public $js       = [
        'release/go.js',
        'extensions/goSamples.js',
        'assets/js/highlight.js',
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
    ];
}
