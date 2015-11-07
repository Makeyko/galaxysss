<?php

namespace app\models\Form\Shop;

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
class Product extends \cs\base\BaseForm
{
    const TABLE = 'gs_unions_shop_product';

    public $id;
    public $tree_node_id;
    public $name;
    public $description;
    public $date_insert;
    public $sort_index;
    public $content;
    public $image;
    public $union_id;

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
                'tree_node_id',
                'Категория',
                0,
                'default',
                'widget' => [
                    'app\modules\Shop\services\CheckBoxTreeMask\CheckBoxTreeMask',
                    [
                        'rows' => (new Query())->select([
                            'id',
                            'name'
                        ])->from('gs_unions_shop_tree')->all(),
                        'tableName' => 'gs_unions_shop_tree'
                    ]
                ]
            ],
        ];
        parent::__construct($fields);
    }

    public function insert2($id)
    {
        $this->union_id = $id;
        return parent::insert([
            'beforeInsert' => function ($fields, \app\models\Form\Shop\Product $model) {
                $fields['date_insert'] = time();
                $fields['union_id'] = $model->union_id;

                return $fields;
            },
        ]);
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
