<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace cs\assets;

use yii\web\AssetBundle;
use cs\Application;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CountDownAsset extends AssetBundle
{
    public $sourcePath = '@csRoot/vendor/Reflejo/jquery-countdown';
    public $css = [
    ];
    public $js = [
        'js/jquery.countdown.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
