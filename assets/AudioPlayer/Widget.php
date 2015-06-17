<?php

namespace app\assets\AudioPlayer;

use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;

class Widget extends Object
{

    public $options = [];

    /**
     * @param array $musicList
     * [
     * [
     *    'file' => str
     *    'title' => str
     *    'artist' => str
     * ], ...
     * ]
     * @param array $options
     * [
     * [
     *    'name' => 'value'
     * ], ...
     * ]
     * @return string HTML
     */
    public function run($musicList, $options = [])
    {
        $this->register();

        $soundFile = [];
        $titles = [];
        $artists = [];
        foreach($musicList as $item) {
            $soundFile[] = ArrayHelper::getValue($item, 'file', '');
            $titles[] = ArrayHelper::getValue($item, 'title', '');
            $artists[] = ArrayHelper::getValue($item, 'artist', '');
        }
        $options = ArrayHelper::merge($options, [
            'soundFile' => join(',', $soundFile),
            'titles'    => join(',', $titles),
            'artists'   => join(',', $artists),
        ]);
        $optionsJson = Json::encode($options);
        $js = "AudioPlayer.embed('audioplayer_1', {$optionsJson});";

        return Html::tag('script', $js, ['type' => 'text/javascript']);
    }

    public function register($options = [])
    {
        $asset = Asset::register(\Yii::$app->view);

        $options = [
            'width' => 290,
        ];
        $options = ArrayHelper::merge($options, $this->options);
        $optionsJson = Json::encode($options);
        $url = $asset->baseUrl . '/player.swf';
        \Yii::$app->view->registerJs("AudioPlayer.setup('{$url}', {$optionsJson}); ");
    }
} 