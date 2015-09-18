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
class Investigator extends \cs\base\BaseForm
{
    public $id;


    public function __get($name)
    {
        if (\yii\helpers\StringHelper::startsWith($name, 'id')) {
            $id = (int)substr($name, 2);
            if (is_null($this->id))return null;

            return \yii\helpers\ArrayHelper($this->id, $id, null);
        }
    }
}
