<?php
namespace cs\assets\ZClip;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@csRoot/assets/ZClip/source';
    public $js = [
        'jquery.zclip.min.js'
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}