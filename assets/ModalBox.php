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
class ModalBox extends AssetBundle
{
    public $sourcePath = '@vendor/dimsemenov/Magnific-Popup/dist';
    public $css      = [
        'magnific-popup.css',
    ];
    public $js       = [
        'jquery.magnific-popup.js',
    ];
    public $depends  = [
        'yii\web\JqueryAsset',
    ];
}
