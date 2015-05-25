<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace cs\Widget\FileUpload2;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@csRoot/Widget/FileUpload2/assets';
    public $css = [
        'index.css'
    ];
    public $js = [
        'handlers.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
