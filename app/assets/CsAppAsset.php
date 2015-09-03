<?php
namespace cs\assets;

use yii\web\AssetBundle;

class CsAppAsset extends AssetBundle
{
    public $sourcePath = '@csRoot/assets/CsAppAsset/source';
    public $js = [
        'js/cs.js'
    ];
    public $css = [
		'css/reset.css',
		'css/text.css',
		'css/site.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'cs\assets\ClearJuiJsAsset',
    ];
}