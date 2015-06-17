<?php


namespace app\services;

use app\models\Service;
use cs\helpers\Html;
use cs\services\Str;
use cs\services\VarDumper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\UnionCategory;
use app\models\Union;

class GsssHtml
{
    public static $formatIcon = [
        370,
        370,
        \cs\Widget\FileUpload2\FileUpload::MODE_THUMBNAIL_CUT
    ];

    /**
     * Печатает все объединения категории
     *
     * @param int $id идентификатор категории
     *
     * @return string HTML
     */
    public static function unionCategoryItems($id)
    {
        $html = [];
        $category = UnionCategory::find($id);
        if (is_null($category)) return '';
        foreach ($category->getUnions() as $item) {
            $html[] = self::unionItem($item);
        }

        return join('', $html);
    }

    public static function unionItem($row)
    {
        return self::unityItem($row);
    }

    public static function unityItem($row)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = Union::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        $header = (isset($row['header'])) ? $row['header'] : $row['name'];
        // Заголовок
        $html[] = Html::tag('div',Html::tag('h3', $header), ['class' => 'header']);
        // подзаголовок
        if (ArrayHelper::keyExists('sub_header', $row)) $html[] = Html::tag('p', $row['sub_header']);
        // картинка с ссылкой
        $html[] = Html::tag('p', Html::a(Html::img($row['img'], ['width' => '100%', 'class' => 'thumbnail']), self::getUnionUrl($row)));
        // Описание
        $content = $row['description'];
        $content = self::getMiniText($content);
        $html[] = Html::tag('p', $content);

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 unityItem']);
    }

    /**
     * Возвращает путь к карточки объединения
     * @param array $row
     *
     * @return string
     */
    private function getUnionUrl($row)
    {
        $url = Url::current();
        $oUrl = new \cs\services\Url($url);
        $arr = explode('/', $oUrl->path);
        if ($arr[1] == 'category') {
            $url = '/category/'.$arr[2].'/'.$row['id'];
        } else {
            $url = '/category/'.$arr[1].'/'.$row['id'];
        }

        return $url;
    }

    public static function unityCategoryItem($row)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = UnionCategory::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        // Заголовок
        $html[] = Html::tag('div',Html::tag('h2', $row['header']), ['class' => 'header']);
        // подзаголовок
        if (ArrayHelper::keyExists('sub_header', $row)) $html[] = Html::tag('p', $row['sub_header']);
        // картинка с ссылкой
        $html[] = Html::tag(
            'p',
            Html::a(
                Html::img(
                    $row['image'],
                    ['width' => '100%', 'class' => 'thumbnail']
                ),
                Url::to(['page/category', 'id' => $row['id_string']])
            )
        );
        // Описание
        $html[] = Html::tag('p', self::getMiniText($row['description']));

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 unityCategoryItem']);
    }

    /**
     * Рисует услугу
     *
     * @param $row
     *
     * @return string
     */
    public static function serviceItem($row)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = Service::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        $header = (isset($row['header'])) ? $row['header'] : $row['name'];
        // Заголовок
        $html[] = Html::tag('div',Html::tag('h2', $header), ['class' => 'header']);
        // подзаголовок
        if (ArrayHelper::keyExists('sub_header', $row)) $html[] = Html::tag('p', $row['sub_header']);
        // Ссылка
        if ($row['content'].'' != ''){
            $l = ['page/services_item', 'id' => $row['id']];
            $html[] = Html::tag('p', Html::a(Html::img($row['image'], ['width' => '100%', 'class' => 'thumbnail']), $l));
        } else {
            $l = $row['link'];
            $html[] = Html::tag('p', Html::a(Html::img($row['image'], ['width' => '100%', 'class' => 'thumbnail']), $l, ['target' => '_blank']));
        }
        // Описание
        $html[] = $row['description'];

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 serviceItem']);
    }

    public static function newsItem($row)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = \app\models\NewsItem::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        // Заголовок
        $html[] = Html::tag('div',Html::tag('h4', $row['header']), ['class' => 'header']);
        // Дата
        $html[] = Html::tag('p', self::dateString($row['date']), Html::css([
            'font-size' => '70%',
            'color'     => '#808080',
        ]));
        // картинка с ссылкой
        $html[] = Html::tag('p', Html::a(Html::img($row['img'], ['width' => '100%', 'class' => 'thumbnail']), self::getNewsUrl($row)));
        // Описание
        $content = $row['description'];
        if ($content.'' == '') {
            $content = \cs\services\Str::sub(strip_tags ($row['content']) , 0 , 200) . ' ...';
        }
        $html[] = Html::tag('p', $content);

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 newsItem']);
    }

    public static function getNewsUrl($row, $isFull = false)
    {
        $year = substr($row['date'], 0, 4);
        $month = substr($row['date'], 5, 2);
        $day = substr($row['date'], 8, 2);

        return Url::to(['page/news_item', 'year' => $year, 'month' => $month, 'day' => $day, 'id' => $row['id_string']], $isFull);
    }

    public static function chennelingItem($row)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = \app\models\Chenneling::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        // Заголовок
        $html[] = Html::tag('div',Html::tag('h4', $row['header']), ['class' => 'header']);
        // Дата
        $html[] = Html::tag('p', self::dateString($row['date']), Html::css([
            'font-size' => '70%',
            'color'     => '#808080',
        ]));
        // картинка с ссылкой
        $year = substr($row['date'], 0, 4);
        $month = substr($row['date'], 5, 2);
        $day = substr($row['date'], 8, 2);
        $html[] = Html::tag('p', Html::a(Html::img($row['img'], ['width' => '100%', 'class' => 'thumbnail']), "/chenneling/{$year}/{$month}/{$day}/{$row['id_string']}"));
        // Описание
        $content = $row['description'];
        if ($content.'' == '') {
            $content = self::getMiniText($row['content']);
        }
        $html[] = Html::tag('p', $content);

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 chennelingItem']);
    }

    public static function articleItem($row, $category)
    {
        if (!is_array($row)) {
            $id = $row;
            $item = \app\models\Article::find($id);
            if (is_null($item)) return '';
            $row = $item->getFields();
        }
        // Заголовок
        $html[] = Html::tag('div', Html::tag('h4', $row['header']), ['class' => 'header']);
        // ссылка
        $item2 = [
            'id'       => $row['id_string'],
            'year'     => substr($row['date_insert'], 0, 4),
            'month'    => substr($row['date_insert'], 5, 2),
            'day'      => substr($row['date_insert'], 8, 2),
            'category' => $category,
        ];
        $link = "/category/{$item2['category']}/article/{$item2['year']}/{$item2['month']}/{$item2['day']}/{$item2['id']}";

        // картинка с ссылкой
        $html[] = Html::tag('p', Html::a(Html::img($row['image'], [
                        'width' => '100%',
                        'class' => 'thumbnail'
                    ]), $link));
        // Описание
        $content = $row['description'];
        if ($content.'' == '') {
            $content = self::getMiniText($row['content']);
        } else {
            $content = self::getMiniText($content);
        }
        $html[] = Html::tag('p', $content);

        return Html::tag('div', join('', $html), ['class' => 'col-lg-4 articleItem']);
    }

    /**
     * Возвращает дату в формате "d M Y г." например "1 Дек 2015 г."
     *
     * @param $date 'yyyy-mm-dd'
     *
     * @return string
     */
    public static function dateString($date)
    {
        if (is_null($date)) return '';
        if ($date == '') return '';

        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);
        if (substr($month, 0, 1) == '0') $month = substr($month, 1, 1);
        if (substr($day, 0, 1) == '0') $day = substr($day, 1, 1);
        $monthList = [
            1  => 'Янв',
            2  => 'Фев',
            3  => 'Мар',
            4  => 'Апр',
            5  => 'Май',
            6  => 'Июн',
            7  => 'Июл',
            8  => 'Авг',
            9  => 'Сен',
            10 => 'Окт',
            11 => 'Ноя',
            12 => 'Дек',
        ];
        $month = $monthList[ $month ];

        return "{$day} {$month} {$year} г.";
    }

    public static function getMiniText($text)
    {
        $strip = strip_tags($text);
        $len = 200;

        if (Str::length($strip) > $len) {
            return Str::sub($strip,0, $len) . ' ...';
        }
        return $strip;
    }
} 