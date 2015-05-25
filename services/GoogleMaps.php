<?php

namespace app\services;


use yii\base\Object;
use yii\helpers\Html;
use cs\services\Security;
use cs\services\VarDumper;

class GoogleMaps extends Object
{
    /** @var  \yii\web\View $view */
    public $view;

    public function init()
    {
        $this->view = \Yii::$app->view;
    }

    /**
     * Рисует карту
     *
     * @param $options
     * - height    - int - ширина
     * - width     - int - высота
     * - id        - int - идентификатор, необязательно
     * - pointList - array [
     *                        [
     *                           'lat'          => float
     *                           'lng'          => float
     *
     *                          'name'         => str
     *                           'description'  => str
     *                           'url'          => str
     *                           'image'        => str - картинка
     *
     * 'html'         => str
     *                        ], ...
     *                     ]
     *
     * @return string
     */
    public function map($options)
    {
        if (isset($options['id'])) {
            $id = $options['id'];
        } else {
            $id = 'map-' . Security::generateRandomString(10);
        }
        \cs\assets\GoogleMaps::register($this->view);
        $this->view->registerCss(<<<CSS
#{$id} {
    width: {$options['width']}px;
    height: {$options['height']}px;
    margin: 0px;
    padding: 0px;
    margin-top: 10px;
    border-radius: 12px;
    border: 1px solid #ccc;
}
CSS
        );
        $mapOptions = self::getMapOptions($options['pointList']);
        $zoom = $mapOptions['zoom'];
        $positionLat = $mapOptions['position']['lat'];
        $positionLng = $mapOptions['position']['lng'];
        $pointList = json_encode($options['pointList'], JSON_UNESCAPED_UNICODE);
        if (isset($options['pointList'][0]['description'])) {
            $this->view->registerJs(<<<JS
var pointList = {$pointList};
var map = new google.maps.Map(document.getElementById('{$id}'), {
    center: new google.maps.LatLng({$positionLat}, {$positionLng}),
    zoom: {$zoom}
});
$.each(pointList, function(i,v) {
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(v.lat, v.lng),
        map: map
    });
    var contentString = '<h3>' + v.name + '</h3>';
    if (v.image != '') contentString += '<img src="'+v.image+'" height="100">';
    if (v.description != '') contentString += '<div style="display:block; margin-top:20px;">' + v.description + '</div>';
    if (v.url != '') contentString += '<a href="' + v.url + '" target="_blank" style="margin-top:20px;">' + v.url + '</a>';
    var infoWindow = new google.maps.InfoWindow({
      content: contentString
    });
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.open(map, marker);
    });
});

JS
            );
        } else {
            $this->view->registerJs(<<<JS
var pointList = {$pointList};
var map = new google.maps.Map(document.getElementById('{$id}'), {
    center: new google.maps.LatLng({$positionLat}, {$positionLng}),
    zoom: {$zoom}
});
$.each(pointList, function(i,v) {
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(v.lat, v.lng),
        map: map
    });
    var infoWindow = new google.maps.InfoWindow({
      content: v.html
    });
    google.maps.event.addListener(marker, 'click', function() {
        infoWindow.open(map, marker);
    });
});

JS
            );

        }

        return Html::tag('div', null, [
            'id' => $id,
        ]);
    }

    /**
     * Определяет параметры карты
     * позиция и зум
     *
     * @param array $pointList
     * [
     *  'lat' => double
     *  'lng' => double
     *  'html' => string
     * ]
     *
     * @return array
     */
    public function getMapOptions($pointList)
    {
        if (count($pointList) == 0) return [
            'position' => [
                'lat' => 30,
                'lng' => 30
            ],
            'zoom'     => 1,
        ];

        $lat = 0;
        $lng = 0;
        $latMin = $pointList[0]['lat'];
        $latMax = $pointList[0]['lat'];
        $lngMin = $pointList[0]['lng'];
        $lngMax = $pointList[0]['lng'];
        $c = 0;
        foreach($pointList as $item) {
            $lat += $item['lat'];
            $lng += $item['lng'];
            if ($item['lat'] < $latMin) {
                $latMin = $item['lat'];
            } else if ($item['lat'] > $latMax) {
                $latMax = $item['lat'];
            }
            if ($item['lng'] < $lngMin) {
                $lngMin = $item['lng'];
            } else if ($item['lng'] > $lngMax) {
                $lngMax = $item['lng'];
            }
            $c++;
        }
        $lat = $lat / $c;
        $lng = $lng / $c;
        $latDelta = $latMax - $latMin;
        $lngDelta = $lngMax - $lngMin;
        $delta = ($lngDelta > $latDelta)? $lngDelta : $latDelta;
        $map = [
            1 => 90,
            2 => 60,
            3 => 45,
            4 => 30,
            5 => 20,
            6 => 10,
            7 => 5,
            8 => 2,
            9 => 1,
            10 => 0.5,
            11 => 0.3,
            12 => 0.1,
            13 => 0.05,
            14 => 0.01,
            15 => 0.005,
            16 => 0.001,
        ];
        foreach ($map as $k => $v) {
            if ($v > $delta) $zoom = $k;
        }

        return [
            'position' => [
                'lat' => $lat,
                'lng' => $lng
            ],
            'zoom'     => $zoom,
        ];
    }
} 