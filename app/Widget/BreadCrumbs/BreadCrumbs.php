<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 14.09.2015
 * Time: 16:19
 */

namespace cs\Widget\BreadCrumbs;


use cs\helpers\Html;
use yii\base\Object;
use yii\helpers\Url;

class BreadCrumbs extends Object
{
    /** @var  array
     * [
     *   <[
     *      'label' =>
     *      'url' => array|string
     *   ] | string> , ...
     * ]
     */
    public $items;


    public function run()
    {
        $this->registerAssets();


        $items = [
            '<a href="#" class="btn btn-default"><i class="fa fa-home"></i></a>',
            '<div class="btn btn-default">...</div>',
        ];
        foreach ($this->items as $item) {
            if (is_array($item)) {
                $url = $item['url'];
                $name = $item['label'];
            } else {
                $url = 'javascript:void();';
                $name = $item;
            }
            $items[] = Html::a(Html::tag('div', $name), Url::to($url), ['class' => 'btn btn-default']);
        }
        $items = join('', $items);

        return Html::tag('div', $items, ['class' => 'btn-group btn-breadcrumb']);
    }

    private function registerAssets()
    {
        \cs\assets\BreadCrumbs\Asset::register(\Yii::$app->view);
        \Yii::$app->view->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css');
    }

    public static function widget($config = [])
    {
        $class = new self($config);

        return $class->run();
    }
} 