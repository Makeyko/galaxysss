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
class Article extends \cs\base\BaseForm
{
    const TABLE = 'gs_article_list';

    public $id;
    public $header;
    public $sort_index;
    public $content;
    public $date_insert;
    public $image;
    public $id_string;
    public $source;
    public $view_counter;
    public $description;
    public $date;
    /** @var  int маска которая содержит идентификаторы разделов к которому принадлежит ченелинг */
    public $tree_node_id_mask;

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
                        ])->from('gs_article_tree')->all()
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
                if (Str::pos('<', $fields['content']) === false) {
                    $rows = explode("\r", $fields['content']);
                    $rows2 = [];
                    foreach ($rows as $row) {
                        if (trim($row) != '') $rows2[] = Html::tag('p', trim($row));
                    }
                    $fields['content'] = join("\r\r", $rows2);
                }

                $fields['date_insert'] = gmdate('YmdHis');
                $fields['id_string'] = Str::rus2translit($fields['header']);
                $fields['date'] = gmdate('Y-m-d');

                return $fields;
            }
        ]);
    }

    public function update($fieldsCols = null)
    {
        return parent::update([
            'beforeUpdate' => function ($fields) {
                if (Str::pos('<', $fields['content']) === false) {
                    $rows = explode("\r", $fields['content']);
                    $rows2 = [];
                    foreach ($rows as $row) {
                        if (trim($row) != '') $rows2[] = Html::tag('p', trim($row));
                    }
                    $fields['content'] = join("\r\r", $rows2);
                }

                return $fields;
            }
        ]);
    }

}
