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
class Chenneling extends \cs\base\BaseForm
{
    const TABLE = 'gs_cheneling_list';

    public $isIncludeScriptOnWindowClose = true;

    public $id;
    public $header;
    public $sort_index;
    public $content;
    public $date_insert;
    public $img;
    public $id_string;
    public $source;
    public $view_counter;
    public $description;
    public $date;
    public $is_added_site_update;
    /** @var  int маска которая содержит идентификаторы разделов к которому принадлежит ченелинг */
    public $tree_node_id_mask;
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
                'description',
                'Описание краткое',
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
                    'cs\Widget\CheckBoxTreeMask\CheckBoxTreeMask',
                    [
                        'tableName' => 'gs_cheneling_tree'
                    ]
                ]
            ],
        ];
        parent::__construct($fields);
    }

    /**
     * @param null $fieldsCols
     *
     * @return \app\models\Chenneling
     */
    public function insert($fieldsCols = null)
    {
        $row = parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['date_insert'] = gmdate('YmdHis');
                $fields['id_string'] = Str::rus2translit($fields['header']);
                $fields['date'] = gmdate('Y-m-d');

                return $fields;
            },
        ]);

        $item = new \app\models\Chenneling($row);
        if ($this->is_add_image) {
            $fields = ['content' => Html::tag('p', Html::img(\cs\Widget\FileUpload2\FileUpload::getOriginal($item->getField('img')), [
                    'class' => 'thumbnail',
                    'style' => 'width:100%;',
                    'alt'   => $item->getField('header'),
                ])) . $item->getField('content')];
        }
        if ($row['description'] == '') {
            $fields['description'] = GsssHtml::getMiniText($row['content']);
        }
        $item->update($fields);

        return $item;
    }

    public function update($fieldsCols = null)
    {
        return parent::update([
            'beforeUpdate' => function ($fields, \app\models\Form\Chenneling $model) {
                if ($fields['description'] == '') {
                    $fields['description'] = GsssHtml::getMiniText($fields['content']);
                }
                if ($model->is_add_image) {
                    \Yii::info(\yii\helpers\VarDumper::dump($model), 'gs\\Chenneling');
                    \Yii::info($fields, 'gs\\Chenneling');
                    \Yii::info($fields['img'], 'gs\\Chenneling');
                    \Yii::info(\cs\Widget\FileUpload2\FileUpload::getOriginal($model->img), 'gs\\Chenneling');
                    $fields['content'] = Html::tag('p', Html::img(\cs\Widget\FileUpload2\FileUpload::getOriginal($model->img), [
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
