<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets\ModalBoxNew;

use yii\helpers\VarDumper;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@app/assets/ModalBoxNew/asset';
    public $css      = [
        'index.css',
    ];
    public $js       = [
        'index.js',
    ];
    public $depends  = [
        'app\assets\ModalBox',
    ];
}
