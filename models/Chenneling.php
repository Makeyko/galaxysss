<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 05.05.2015
 * Time: 23:41
 */

namespace app\models;


use app\services\Subscribe;

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

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = '';
        // опции шаблона
        $options = [];

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
}