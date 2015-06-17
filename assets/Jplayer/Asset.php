<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets\Jplayer;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath  = '@app/assets/Jplayer/source';
    public $css     = [
        'css/index.css',
    ];
    public $js      = [
        'js/jquery.jplayer.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
