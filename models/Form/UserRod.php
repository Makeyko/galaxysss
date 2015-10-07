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
class UserRod extends \cs\base\BaseForm
{
    const TABLE = 'gs_users_rod';

    public $id;
    public $gender;
    public $name_first;
    public $name_last;
    public $name_middle;
    public $date_born;
    public $date_death;
    public $koleno;
    public $child_id;
    public $description;
    public $content;
    public $image;
    public $user_id;
    public $rod_id;

    function __construct($fields = [])
    {
        static::$fields = [
            [
                'name_first',
                'Имя',
                0,
                'string'
            ],
            [
                'name_last',
                'Фамилия',
                0,
                'string'
            ],
            [
                'name_middle',
                'Отчество',
                0,
                'string'
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
            [
                'date_born',
                'Дата рождения',
                0,
                'cs\Widget\DatePicker\Validator',
                'widget' => [
                    'cs\Widget\DatePicker\DatePicker',
                    [
                    ]
                ]
            ],
            [
                'date_death',
                'Дата смерти',
                0,
                'cs\Widget\DatePicker\Validator',
                'widget' => [
                    'cs\Widget\DatePicker\DatePicker',
                    [
                    ]
                ]
            ],
        ];
        parent::__construct($fields);
    }

}
