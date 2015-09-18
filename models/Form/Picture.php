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
class Picture extends \cs\base\BaseForm
{
    const TABLE = 'gs_pictures';

    public $id;
    /** @var  array */
    public $file;
    public $is_added;
    /** @var  array */
    public $tree_node_id_mask;

    function __construct($fields = [])
    {
        static::$fields = [

            [
                'file',
                'Описание',
                0,
                'default',
                'widget' => [
                    'cs\Widget\FileUploadMany\FileUploadMany',
                    [
                    ]
                ]
            ],

        ];
        parent::__construct($fields);
    }

    public function insert($fields = null)
    {

        $path = \Yii::getAlias(\cs\Widget\FileUploadMany\FileUploadMany::$uploadDirectory);
        foreach($this->file as $file) {
            $filePath = $path . DIRECTORY_SEPARATOR . $file[0];
            \cs\services\VarDumper::dump($filePath);
        }
    }


}
