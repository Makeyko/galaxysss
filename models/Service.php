<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 05.05.2015
 * Time: 23:41
 */

namespace app\models;


use app\services\Subscribe;
use yii\helpers\Url;

class Service extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_services';

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = 'subscribe/service';
        // опции шаблона
        $options = [
            'item' => $this,
            'user' => \Yii::$app->user->identity,
        ];

        /** @var \yii\swiftmailer\Mailer $mailer */
        $mailer = \Yii::$app->mailer;
        $text = $mailer->render('text/' . $view, $options, 'layouts/text/subscribe');
        $html = $mailer->render('html/' . $view, $options, 'layouts/html/subscribe');

        $subscribeItem = new SubscribeItem();
        $subscribeItem->subject = $this->getName();
        $subscribeItem->html = $html;
        $subscribeItem->text = $text;
        $subscribeItem->type = Subscribe::TYPE_SITE_UPDATE;

        return $subscribeItem;
    }

    /**
     * @inheritdoc
     */
    public function getSiteUpdateItem($isScheme = false)
    {
        $siteUpdateItem = new SiteUpdateItem();
        $siteUpdateItem->name = $this->getName();
        $siteUpdateItem->image = $this->getImage($isScheme);
        $siteUpdateItem->link = $this->getLink($isScheme);
        $siteUpdateItem->type = SiteUpdateItem::TYPE_SERVICE;

        return $siteUpdateItem;
    }

    /**
     * Возвращает название услуги
     *
     * @return string
     */
    public function getName()
    {
        return $this->getField('header', '');
    }

    /**
     * Возвращает ссылку на картинку
     * @param bool $isScheme
     *
     * @return string
     */
    public function getImage($isScheme = false)
    {
        $url = $this->getField('image', '');
        if ($url == '') return '';

        return Url::to($url, $isScheme);
    }

    /**
     * Возвращает ссылку на услугу
     * @param bool $isScheme
     *
     * @return string
     */
    public function getLink($isScheme = false)
    {
        return Url::to(['page/services_item', 'id' => $this->getId()], $isScheme);
    }
}