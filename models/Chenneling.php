<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 05.05.2015
 * Time: 23:41
 */

namespace app\models;


use app\services\Subscribe;
use cs\services\Url;

class Chenneling extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_cheneling_list';

    /**
     * Ключ для memcache для сохранения страницы всех ченелингов
     */
    const MEMCACHE_KEY_LIST = '\app\controllers\PageController::actionChenneling';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    public static function clearCache()
    {
        \Yii::$app->cache->delete(self::MEMCACHE_KEY_LIST);
    }

    public function getName()
    {
        return $this->getField('header');
    }

    public function getImage($isScheme = false)
    {
        if ($isScheme) {
            return \yii\helpers\Url::to($this->getField('img'), true);
        }

        return $this->getField('img');
    }

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = 'subscribe/channeling';
        // опции шаблона
        $options = [
            'item' => $this,
            'user' => \Yii::$app->user->identity,
        ];

        /** @var \yii\swiftmailer\Mailer $mailer */
        $mailer = \Yii::$app->mailer;
        $text = $mailer->render('text/' . $view, $options, 'layouts/text');
        $html = $mailer->render('html/' . $view, $options, 'layouts/html');

        $subscribeItem = new SubscribeItem();
        $subscribeItem->subject = $this->getName();
        $subscribeItem->html = $html;
        $subscribeItem->text = $text;
        $subscribeItem->type = Subscribe::TYPE_SITE_UPDATE;

        return $subscribeItem;
    }

    /**
     * Возвращает ссылку на ченелинг
     *
     * @param bool $isScheme надо ли добавлять полный путь
     *
     * @return string
     */
    public function getLink($isScheme = false)
    {
        $date = $this->getField('date');
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);

        return \yii\helpers\Url::to([
            'page/chenneling_item',
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'id'    => $this->getField('id_string'),
        ], $isScheme);
    }
}