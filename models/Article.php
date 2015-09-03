<?php

namespace app\models;

use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;

class Article extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_article_list';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    /**
     * Выдает элементы которые соответствуют определенной категории
     *
     * @param int $id идентификатор категории
     *
     * @return array
     */
    public static function getByTreeNodeId($id)
    {
        return self::query(['&', 'tree_node_id_mask', (new BitMask([$id]))->getMask()])
            ->orderBy(['date_insert' => SORT_DESC])
            ->select('id,header,id_string,image,view_counter,description,date_insert,content')
            ->all();
    }

    /**
     * Выдает элементы которые соответствуют определенной категории
     *
     * @param int $id идентификатор категории
     *
     * @return Query
     */
    public static function getByTreeNodeIdQuery($id)
    {
        return self::query(['&', 'tree_node_id_mask', (new BitMask([$id]))->getMask()])
            ->orderBy(['date_insert' => SORT_DESC])
            ->select('id,header,id_string,image,view_counter,description,date_insert,content')
            ;
    }

    public function getName()
    {
        return $this->getField('header');
    }

    public function getImage($isScheme = false)
    {
        $image = $this->getField('image', '');
        if ($image == '') return '';

        return \yii\helpers\Url::to($this->getField('image'), $isScheme);
    }

    /**
     * @inheritdoc
     */
    public function getMailContent()
    {
        // шаблон
        $view = 'subscribe/article';
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
        $siteUpdateItem->type = SiteUpdateItem::TYPE_ARTICLE;

        return $siteUpdateItem;
    }

    /**
     * Возвращает ссылку на статью
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
            'page/article',
            'year'  => $year,
            'month' => $month,
            'day'   => $day,
            'id'    => $this->getField('id_string'),
            'category'    => UnionCategory::getIdStringById(
                (new BitMask($this->getField('tree_node_id_mask')))
                ->getArray()[0]
            )
        ], $isScheme);
    }
}