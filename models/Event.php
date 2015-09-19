<?php

namespace app\models;

use cs\services\BitMask;
use yii\db\Query;
use app\services\Subscribe;

class Event extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_events';

    public function getName()
    {
        return $this->getField('name');
    }

    public function getImage($isScheme = false)
    {
        $image = $this->getField('image', '');
        if ($image == '') return '';

        return \yii\helpers\Url::to($this->getField('image'), $isScheme);
    }

    public function getLink($isScheme = false)
    {
        return \yii\helpers\Url::to(['calendar/events_item', 'id' => $this->getId()], $isScheme);
    }

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = 'subscribe/event';
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
        $siteUpdateItem->type = SiteUpdateItem::TYPE_EVENT;

        return $siteUpdateItem;
    }

}