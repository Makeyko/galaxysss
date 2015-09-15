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
class Blog extends \cs\base\BaseForm
{
    const TABLE = 'gs_blog';

    public $id;
    public $header;
    public $content;
    public $date_insert;
    public $date_update;
    public $image;
    public $id_string;
    public $source;
    public $view_counter;
    public $description;
    public $date;
    /** @var  int маска которая содержит идентификаторы разделов к которому принадлежит ченелинг */
    public $tree_node_id_mask;
    public $is_added_site_update;
    /** @var  bool */
    public $is_add_image = true;

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
                'is_add_image',
                'Добавлять картинку вначале статьи?',
                0,
                'cs\Widget\CheckBox2\Validator',
                'widget' => [
                    'cs\Widget\CheckBox2\CheckBox',
                ],
                'isFieldDb' => false,
            ],
            [
                'source',
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
            [
                'tree_node_id_mask',
                'Категории',
                0,
                'cs\Widget\CheckBoxListMask\Validator',
                'widget' => [
                    'cs\Widget\CheckBoxListMask\CheckBoxListMask',
                    [
                        'rows' => (new Query())->select([
                            'id',
                            'name'
                        ])->from('gs_blog_tree')->all()
                    ]
                ]
            ],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        $fields = parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = time();
                $fields['id_string'] = Str::rus2translit($fields['header']);
                $fields['date'] = gmdate('Y-m-d');

                return $fields;
            },
        ]);

        $item = new \app\models\Blog($fields);
        if ($this->is_add_image) {
            $fields = ['content' => Html::tag('p', Html::img(\cs\Widget\FileUpload2\FileUpload::getOriginal($item->getImage()), [
                    'class' => 'thumbnail',
                    'style' => 'width:100%;',
                    'alt'   => $item->getField('header'),
                ])) . $item->getField('content')];
        }
        if ($item->getField('description', '') == '') {
            $fields['description'] = GsssHtml::getMiniText($item->getField('content', ''));
        }
        $item->update($fields);

        return $item;
    }

    public function update($fieldsCols = null)
    {
        return parent::update([
            'beforeUpdate' => function ($fields, \app\models\Form\Blog $model) {
                if ($fields['description'] == '') {
                    $fields['description'] = GsssHtml::getMiniText($fields['content']);
                }
                if ($model->is_add_image) {
                    $fields['content'] = Html::tag('p', Html::img(\cs\Widget\FileUpload2\FileUpload::getOriginal($fields['img']), [
                            'class' => 'thumbnail',
                            'style' => 'width:100%;',
                            'alt'   => $fields['header'],
                        ])) . $fields['content'];
                }

                return $fields;
            }
        ]);
    }

}
