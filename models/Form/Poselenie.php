<?php

namespace app\models\Form;

use app\models\User;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;

/**
 * ContactForm is the model behind the contact form.
 */
class Poselenie extends \cs\base\BaseForm
{
    const TABLE = 'gs_posoleniya';

    public $id;
    public $name;
    public $point_lat;
    public $point_lng;
    public $point_address;
    public $description;
    public $image;
    public $view_counter;
    public $user_id;
    public $date_insert;
    public $url;

    function __construct($fields = [])
    {
        static::$fields = [
            ['name', 'Название', 1, 'string'],
            ['url', 'Ссылка', 0, 'url'],
            ['point', 'Местоположение', 0, 'widget' => ['cs\Widget\PlaceMap\PlaceMap']],
            ['description', 'Описание', 1, 'string'],
            ['image', 'Картинка', 0, 'string', 'widget' => [FileUpload::className(), ['options' => [
                'small' => \app\services\GsssHtml::$formatIcon
            ]]]],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        $fields = parent::insert();
        (new \app\models\Poselenie($fields))->update([
            'user_id'     => Yii::$app->user->identity->getId(),
            'date_insert' => gmdate('YmdHis'),
        ]);

        return true;
    }

}
