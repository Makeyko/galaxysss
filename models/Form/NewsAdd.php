<?php

namespace app\models\Form;

use app\models\NewsItem;
use app\models\User;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Model;
use cs\Widget\FileUpload2\FileUpload;
use yii\helpers\Html;

/**
 * ContactForm is the model behind the contact form.
 */
class NewsAdd extends \cs\base\BaseForm
{
    const TABLE = 'gs_news';

    public $id;
    public $header;
    public $sort_index;
    public $content;
    public $date_insert;
    public $date_update;
    public $date;
    public $author;
    public $img;
    public $is_show;
    public $id_string;
    public $source;
    public $view_counter;
    public $description;

    function __construct($fields = [])
    {
        static::$fields = [
            ['header', 'Название', 1, 'string'],
            ['source', 'Ссылка', 0, 'url'],
            ['content', 'Описание', 1, 'string'],
            ['img', 'Картинка', 0, 'string', 'widget' => [FileUpload::className(), ['options' => [
                'small' => \app\services\GsssHtml::$formatIcon
            ]]]],
        ];
        parent::__construct($fields);
    }

    public function insert($fieldsCols = null)
    {
        return  parent::insert([
            'beforeInsert' => function ($fields) {
                if (Str::pos('<', $fields['content']) === false) {
                    $rows = explode("\r", $fields['content']);
                    $rows2 = [ ];
                    foreach($rows as $row) {
                        if (trim($row) != '') $rows2[] = Html::tag('p',  trim($row));
                    }
                    $fields['content'] = join("\r\r", $rows2);
                }

                $fields['date_insert'] = gmdate('YmdHis');
                $fields['id_string'] =  Str::rus2translit($fields['header']);
                $fields['is_show'] = 1;
                $fields['date'] = gmdate('Y-m-d');

                return $fields;
            }
        ]);
    }

}
