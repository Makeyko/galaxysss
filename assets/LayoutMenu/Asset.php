<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets\LayoutMenu;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath  = '@app/assets/LayoutMenu/source';
    public $css     = [
        'css/sticky-footer-navbar.css',
    ];
    public $js      = [
        'index.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
