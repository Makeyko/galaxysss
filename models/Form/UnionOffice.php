<?php

namespace app\models\Form;

use app\models\User;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;

/**
 * ContactForm is the model behind the contact form.
 */
class UnionOffice extends \cs\base\BaseForm
{
    const TABLE = 'gs_unions_office';

    public $id;
    public $union_id;
    public $name;
    public $point;
    public $point_address;
    public $point_lat;
    public $point_lng;
    public $content;

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
                'point',
                'Местоположение',
                0,
                'string',
                'widget' => [
                    'cs\Widget\PlaceMap\PlaceMap'
                ]
            ],
            [
                'content',
                'Время работы и контакты',
                0,
                'string',
                [
                    'min' => 1,
                    'max' => 2000
                ],
                'widget' => [
                    'cs\Widget\HtmlContent\HtmlContent'
                ]
            ],
        ];
        parent::__construct($fields);
    }

    public function insert()
    {
        $this->clearCache();

        return parent::insert([
            'beforeInsert' => function ($fields) {
                $fields['union_id'] = $this->union_id;

                return $fields;
            }
        ]);
    }

    public function delete()
    {
        $this->clearCache();

        return parent::delete();
    }

    public function update($fields = null)
    {
        $this->clearCache();

        return parent::update($fields);
    }

    private function clearCache()
    {
        \app\models\Union::deleteCacheOfficeList($this->union_id);
    }
}
