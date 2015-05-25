<?php


namespace app\assets\App;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@app/assets/App/source';
    public $css      = [
    ];
    public $js       = [
        'cs.js',
    ];
    public $depends  = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
