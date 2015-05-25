<?php
namespace cs\assets;

use yii\web\AssetBundle;

class GoogleMaps extends AssetBundle
{
    public $js = [
        '//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places',
    ];
    public $css = [
    ];
    public $depends = [
    ];
}