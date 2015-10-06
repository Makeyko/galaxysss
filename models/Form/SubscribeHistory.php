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
 * ContactForm is the model behind the contact form.
 */
class SubscribeHistory extends \cs\base\BaseForm
{
    const TABLE = 'gs_subscribe_history';

    public $id;
    public $content;
    public $date_insert;
    public $subject;
    public $is_send;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'content',
                'Содержание',
                0,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
                    ]
                ]
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
        // получаю content
        {
            $content = $class->getField('content');
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $content = str_get_html($content);
            foreach ($content->find('img') as $element) {
                $src = $element->attr['src'];
                if (StringHelper::startsWith($src, 'http') == false) {
                    $element->attr['src'] = Url::to($src, true);
                }
            }
            $content = $content->root->outertext();
            $class->setContent($content);
        }

        return $item;
    }

    public function update2($id)
    {
        $item = parent::update();
        $item['id'] = $id;
        $class = new \app\models\SubscribeHistory($item);
        // получаю content
        {
            $content = $class->getField('content');
            require_once(Yii::getAlias('@csRoot/services/simplehtmldom_1_5/simple_html_dom.php'));
            $content = str_get_html($content);
            foreach ($content->find('img') as $element) {
                $src = $element->attr['src'];
                if (StringHelper::startsWith($src, 'http') == false) {
                    $element->attr['src'] = Url::to($src, true);
                }
            }
            $content = $content->root->outertext();
            $class->setContent($content);
        }

        return $item;
    }

}
