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
class Category extends \cs\base\BaseForm
{
    const TABLE = 'gs_unions_tree';

    public $id;
    public $parent_id;
    public $header;
    public $sort_index;
    public $date_insert;
    public $date_update;
    public $image;
    public $id_string;
    public $description;

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
                'description',
                'Описание краткое',
                0,
                'string'
            ],
            [
                'parent_id',
                'Родительская ветка',
                0,
                'integer'
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
                $fields['id_string'] = Str::rus2translit($fields['header']);

                return $fields;
            }
        ]);
    }
}
