<?php
namespace cs\assets\Renderer;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@csRoot/assets/Renderer/asset';
    public $js = [
        'index.js'
    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}