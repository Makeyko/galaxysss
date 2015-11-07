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
class Shop extends \cs\base\BaseForm
{
    const TABLE = 'gs_unions_shop';

    public $id;
    public $union_id;
    public $name;
    public $dostavka;
    public $admin_email;

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
                'dostavka',
                'Доставка',
                0,
                'string',
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent',
                    [
                    ]
                ]
            ],
            [
                'admin_email',
                'email для заказов',
                0,
                'email'
            ],
        ];
        parent::__construct($fields);
    }

    /**
     * @param int $id идентификатор объединения gs_unions.id
     * @return array|bool
     */
    public function update2($id)
    {
        if ($this->id) {
            return parent::update();
        } else {
            $this->union_id = $id;
            return parent::insert([
                'beforeInsert' => function ($fields, \app\models\Form\Shop $model) {
                    $fields['union_id'] = $model->union_id;

                    return $fields;
                },
            ]);
        }
    }

}
