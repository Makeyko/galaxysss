<?php

namespace app\models\Form;

use app\models\NewsItem;
use app\models\User;
use app\services\GsssHtml;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class NewsAdd extends \cs\base\BaseForm
{
    const TABLE = 'gs_news';

    public $id;

    public $header;
    public $source;
    public $description;
    public $content;
    public $img;
    public $date_insert;

    public $sort_index;
    public $date_update;
    public $date;
    public $author;
    public $is_show;
    public $id_string;
    public $view_counter;
    public $is_added_site_update;

    function __construct($fields = [])
    {
        static::$fields = [
            ['header', 'Название', 1, 'string'],
            ['description', 'Описание краткое', 0, 'string', [], 'Без HTML'],
            ['source', 'Ссылка', 0, 'url'],
            ['content', 'Описание', 0, 'string', 'widget' => ['cs\Widget\HtmlContent\HtmlContent']],
            ['img', 'Картинка', 0, 'string', 'widget' => [FileUpload::className(), ['options' => [
                'small' => \app\services\GsssHtml::$formatIcon
            ]]]],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        $fields =  parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = gmdate('YmdHis');
                $fields['id_string'] =  Str::rus2translit($fields['header']);
                $fields['is_show'] = 1;
                $fields['date'] = gmdate('Y-m-d');

                return $fields;
            },

        ]);

        if ($fields['description'] == '') {
            $item = new NewsItem($fields);
            $fields['description'] = GsssHtml::getMiniText($fields['content']);
            $item->update($fields);
        }

        return $fields;
    }

    public function update($fieldsCols = null)
    {
        return  parent::update([
            'beforeUpdate' => function ($fields) {
                if ($fields['description'] == '') {
                    $fields['description'] = GsssHtml::getMiniText($fields['content']);
                }

                return $fields;
            }
        ]);
    }
}
