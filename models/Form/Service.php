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
use yii\db\Query;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class Service extends \cs\base\BaseForm
{
    const TABLE = 'gs_services';

    public $id;
    public $link;
    public $header;
    public $content;
    public $image;
    public $description;
    public $date_insert;
    public $is_added_site_update;
    public $id_string;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'header',
                'Название',
                1,
                'string'
            ],
            [
                'link',
                'Ссылка',
                0,
                'url'
            ],
            [
                'content',
                'Описание',
                0,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
                    ]
                ]
            ],
            [
                'description',
                'Описание краткое',
                0,
                'string'
            ],
            [
                'image',
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
            ],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        $row = parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = time();
                $fields['id_string'] = Str::rus2translit($fields['header']);

                return $fields;
            }
        ]);

        $item = new \app\models\Service($row);
        $fields = [];
        if ($row['description'] == '') {
            $fields['description'] = GsssHtml::getMiniText($row['content']);
        }
        $item->update($fields);

        return $item;
    }

    public function update($fieldsCols = null)
    {
        return parent::update([
            'beforeUpdate' => function ($fields) {
                if ($fields['description'] == '') {
                    $fields['description'] = GsssHtml::getMiniText($fields['content']);
                }

                return $fields;
            }
        ]);
    }

}
