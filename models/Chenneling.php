<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 05.05.2015
 * Time: 23:41
 */

namespace app\models;


use app\services\Subscribe;
use cs\services\BitMask;
use cs\services\File;
use cs\services\Str;
use cs\services\Url;
use cs\Widget\FileUpload2\FileUpload;
use yii\base\Exception;

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
        $siteUpdateItem->type = SiteUpdateItem::TYPE_CHANNELING;

        return $siteUpdateItem;
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

    /**
     * @return \yii\db\Query
     */
    public static function queryList()
    {
        return self::query()->select([
            'id',
            'header',
            'source',
            'content',
            'date_insert',
            'id_string',
            'img',
            'view_counter',
            'description',
            'date',
            'tree_node_id_mask',
        ]);
    }

    /**
     * Добавить послание из GetArticle
     *
     * @param \app\services\GetArticle\ExtractorInterface $extractor
     *
     * @return static
     * @throws \yii\base\Exception
     */
    public static function insertExtractorInterface($extractor)
    {
        $row = $extractor->extract();
        if (is_null($row['header'])) {
            throw new Exception('Нет заголовка');
        }
        if ($row['header'] == '') {
            throw new Exception('Нет заголовка');
        }
        if (is_null($row['description'])) {
            throw new Exception('Нет описания');
        }
        if ($row['description'] == '') {
            throw new Exception('Нет описания');
        }
        $fields = [
            'header'            => $row['header'],
            'content'           => $row['content'],
            'description'       => $row['description'],
            'source'            => $extractor->getUrl(),
            'id_string'         => Str::rus2translit($row['header']),
            'date_insert'       => gmdate('YmdHis'),
            'date'              => gmdate('Ymd'),
            'img'               => '',
        ];
        $articleObject = self::insert($fields);
        $model = new \app\models\Form\Chenneling();
        $model->id = $articleObject->getId();
        $image = $row['image'];
        if ($image) {
            try {
                $imageContent = file_get_contents($image);
                $imageUrl = parse_url($image);
                $pathInfo = pathinfo($imageUrl['path']);
                $pathInfo['extension'];
                $fields = FileUpload::save(File::content($imageContent), $pathInfo['extension'], [
                    'img',
                    'Картинка',
                    0,
                    'string',
                    'widget' => [
                        FileUpload::className(),
                        [
                            'options' => [
                                'small' => \app\services\GsssHtml::$formatIcon
                            ]
                        ]
                    ]
                ], $model);
                $articleObject->update($fields);
            } catch (\Exception $e) {

            }
        }

        return $articleObject;
    }
}