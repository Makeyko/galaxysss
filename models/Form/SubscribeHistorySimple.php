<?php

namespace app\models\Form;

use app\models\NewsItem;
use app\models\SubscribeItem;
use app\models\User;
use app\services\Subscribe;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 */
class SubscribeHistorySimple extends \cs\base\BaseForm
{
    const TABLE = 'gs_subscribe_history';

    public $id;
    public $content;
    public $date_insert;
    public $subject;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'content',
                'Содержание',
                0,
                'string',
            ],
            [
                'subject',
                'Тема письма',
                1,
                'string'
            ],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        $item = parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = time();

                return $fields;
            },
        ]);
        $class = new \app\models\SubscribeHistory($item);

        // добавляю рассылку
        {
            $subscribeItem = new SubscribeItem();
            $subscribeItem->subject = $class->getField('subject');
            $subscribeItem->type = Subscribe::TYPE_MANUAL;

            /** @var \yii\swiftmailer\Mailer $mailer */
            $mailer = Yii::$app->mailer;
            $view = 'subscribe/manual';
            $options = [
                'subscribeHistory' => $class
            ];
            $subscribeItem->html = $mailer->render('html/' . $view, $options, 'layouts/html');
            Subscribe::add($subscribeItem);
        }

        return $item;
    }
}
