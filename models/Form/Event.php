<?php

namespace app\models\Form;

use app\models\NewsItem;
use app\models\User;
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
class Event extends \cs\base\BaseForm
{
    const TABLE = 'gs_events';

    public $id;
    public $name;
    public $start_date;
    public $start_time;
    public $end_date;
    public $end_time;
    public $content;
    public $image;
    public $user_id;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'name',
                'Название',
                1,
                'string'
            ],
            [
                'start_date',
                'Старт. Дата',
                0,
                'widget' => [
                    'cs\Widget\DatePicker\DatePicker', [
                        'dateFormat' => 'php:d.m.Y',
                    ]
                ],
            ],
            [
                'start_time',
                'Старт. Время',
                0,
                'string',[],
                'формат чч:мм',
            ],
            [
                'end_date',
                'Старт. Дата',
                0,
                'widget' => [
                    'cs\Widget\DatePicker\DatePicker', [
                        'dateFormat' => 'php:d.m.Y',
                    ]
                ],
            ],
            [
                'end_time',
                'Старт. Время',
                0,
                'string',[],
                'формат чч:мм',

            ],
            [
                'content',
                'Описание',
                1,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
                    ]
                ]
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
        return parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = gmdate('YmdHis');

                return $fields;
            },
            'beforeUpdate' => function ($fields) {
                return $fields;
            },
        ]);
    }

    public function update($fieldsCols = null)
    {
        return parent::update([
            'beforeUpdate' => function ($fields) {
                return $fields;
            }
        ]);
    }

}
