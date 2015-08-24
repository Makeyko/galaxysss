<?php


namespace app\models;


use app\services\Subscribe;
use yii\helpers\Url;

class NewsItem extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_news';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = 'subscribe/news_item';
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
        $subscribeItem->type = Subscribe::TYPE_NEWS;

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
        $siteUpdateItem->type = SiteUpdateItem::TYPE_NEWS_ITEM;

        return $siteUpdateItem;
    }

    public function getName()
    {
        return $this->getField('header', '');
    }

    public function getImage($isScheme = false)
    {
        $link = $this->getField('img', '');
        if ($link == '') {
            return '';
        }

        return Url::to($link, $isScheme);
    }

    public function getLink($isScheme = false)
    {
        $date = $this->getField('date');
        $year = substr($date, 0, 4);
        $month = substr($date, 5, 2);
        $day = substr($date, 8, 2);

        return \yii\helpers\Url::to([
            'page/news_item',
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'id'    => $this->getField('id_string'),
        ], $isScheme);
    }
}