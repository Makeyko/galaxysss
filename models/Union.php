<?php


namespace app\models;


use app\services\Subscribe;
use cs\Application;
use cs\services\VarDumper;
use yii\helpers\Url;

class Union extends \cs\base\DbRecord implements SiteContentInterface
{
    const TABLE = 'gs_unions';
    const PREFIX_CACHE_OFFICE_LIST = '\app\controllers\PageController::actionFood_item::';

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
        $view = 'subscribe/union';
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
     * Возвращает имя объединения
     * @return string
     */
    public function getName()
    {
        return $this->getField('name', '');
    }

    /**
     * Имеет ли объединение магазин?
     * @return bool
     */
    public function hasShop()
    {
        $shop = $this->getShop();
        if (is_null($shop)) return false;
        return true;
    }

    /**
     * Получить объект магазина
     * @return null | \app\models\Shop
     */
    public function getShop()
    {
        return Shop::find(['union_id' => $this->getId()]);
    }

    /**
     * Возвращает картинку для объединения
     * @param bool $isScheme
     * @return string
     */
    public function getImage($isScheme = false)
    {
        $url = $this->getField('img', '');
        if ($url == '') return '';

        return Url::to($url, $isScheme);
    }

    /**
     * Возвращает ссылку на объединение
     *
     * @param bool $isScheme
     *
     * @return string
     */
    public function getLink($isScheme = false)
    {
        $tree_node_id = $this->getField('tree_node_id');
        $idString = UnionCategory::getIdStringById($tree_node_id);
        if ($idString === false) return '';
        $url = Url::to(['page/union_item', 'category' => $idString, 'id' => $this->getId()]);

        return Url::to($url, $isScheme);
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
        $siteUpdateItem->type = SiteUpdateItem::TYPE_UNION;

        return $siteUpdateItem;
    }

    /**
     * @param array | string $select поля для выборки
     *                               должны быть возвращены lat, lng, html
     * @return array
     */
    public function getOfficeList($select = null)
    {
        if (is_null($select)) {
            $select = [
                'point_lat as lat',
                'point_lng as lng',
                'concat("<h5>",point_address,"</h5>") as html',
            ];
        }

        return Application::cache(self::PREFIX_CACHE_OFFICE_LIST . $this->getId(), function($options) {
            $query = UnionOffice::query(['union_id' => $options['union_id']]);

            return $query->select($options['select'])->all();
        }, [
            'select'   => $select,
            'union_id' => $this->getId(),
        ]);
    }

    /**
     * @param int $id идентификатор объединения
     */
    public static function deleteCacheOfficeList($id)
    {
        \Yii::$app->cache->delete(self::PREFIX_CACHE_OFFICE_LIST . $id);
    }

    /**
     * Одобряет объединение
     */
    public function accept()
    {
        $this->update(['moderation_status' => 1]);
    }

    /**
     * Отклоняет объединение
     */
    public function reject()
    {
        $this->update(['moderation_status' => 0]);
    }

    public function getUserId()
    {
        return $this->getField('user_id');
    }

    /**
     * @return \app\models\User
     */
    public function getUser()
    {
        return User::find($this->getUserId());
    }
}