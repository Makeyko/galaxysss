<?php

namespace app\models\Form;

use app\models\User;
use app\services\GsssHtml;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;

/**
 * ContactForm is the model behind the contact form.
 */
class Union extends \cs\base\BaseForm
{
    const TABLE = 'gs_unions';

    public $id;
    public $name;
    public $sub_name;
    public $link;
    public $description;
    public $logo;
    public $aud;
    public $aim;
    public $prednaznach;
    public $mission;
    public $img;
    public $date_insert;
    public $date_update;
    public $tree_node_id;
    public $view_counter;
    public $user_id;
    public $content;
    public $moderation_status;
    public $sort_index;
    public $group_link_google;
    public $group_link_youtube;
    public $group_link_vkontakte;
    public $group_link_facebook;
    public $is_added_site_update;

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
                'sub_name',
                'Название2',
                0,
                'string'
            ],
            [
                'content',
                'Подробности',
                0,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
                    ]
                ]

            ],
            [
                'link',
                'Ссылка',
                1,
                'url'
            ],
            [
                'tree_node_id',
                'Раздел',
                0,
                'integer',
                'widget' => [
                    'cs\Widget\TreeSelect\TreeSelect',
                    [
                        'tableName' => 'gs_unions_tree'
                    ]
                ]
            ],
            [
                'description',
                'Описание',
                0,
                'string',
            ],
            [
                'group_link_facebook',
                'Ссылка на Facebook',
                0,
                'string'
            ],
            [
                'group_link_vkontakte',
                'Ссылка на Vkontakte',
                0,
                'string'
            ],
            [
                'group_link_youtube',
                'Ссылка на Youtube',
                0,
                'string'
            ],
            [
                'group_link_google',
                'Ссылка на Google',
                0,
                'string'
            ],
            [
                'img',
                'Картинка',
                0,
                'string',
                'widget' => [
                    FileUpload::className(),
                    [
                        'options' => [
                            'small' => \app\services\GsssHtml::$formatIcon,
                            'extended' => [
                                'share' => [
                                    470*2,
                                    245*2,
                                    FileUpload::MODE_THUMBNAIL_CUT
                                ]
                            ]
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
                $fields['user_id'] = Yii::$app->user->identity->getId();
                $fields['date_insert'] = gmdate('YmdHis');

                return $fields;
            }
        ]);

        $item = new \app\models\Union($row);
        $fields = [];
        if ($row['description'] == '') {
            $item = new \app\models\Union($row);
            $fields['description'] = GsssHtml::getMiniText($row['content']);
            $item->update($fields);
        }

        return $item;
    }

    public function update($fieldsCols = null)
    {
        parent::update([
            'beforeUpdate' => function ($fields) {
                if ($fields['description'] == '') {
                    $fields['description'] = GsssHtml::getMiniText($fields['content']);
                }

                return $fields;
            }
        ]);

        return true;
    }
}
