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
class Smeta extends \cs\base\BaseForm
{
    const TABLE = 'gs_smeta';

    public $id;
    public $target;
    public $present;
    public $price;
    public $bill;
    public $date_insert;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'target',
                'Назачение',
                0,
                'string',
                           'widget' => [
        'cs\Widget\HtmlContent\HtmlContent',
        [
        ]
    ]
 ],
            [
                'present',
                'Подарок',
                0,
                'string',
                            'widget' => [
        'cs\Widget\HtmlContent\HtmlContent',
        [
        ]
    ]
],
            [
                'price',
                'Цена, тыс руб',
                0,
                'integer'
            ],
            [
                'bill',
                'Счет перечисления',
                0,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
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
