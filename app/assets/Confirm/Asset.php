<?php

namespace cs\assets\Confirm;

use yii\web\AssetBundle;

/**
 */
class Asset extends AssetBundle
{
    public $sourcePath  = '@vendor/mistic100/Bootstrap-Confirmation';
    public $css     = [
    ];
    public $js      = [
        'bootstrap-confirmation.js',
    ];
    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
