<?php

namespace app\models\Form;

use app\models\HD;
use app\models\HDtown;
use app\models\User;
use app\models\Zvezdnoe;
use cs\base\BaseForm;
use cs\services\SitePath;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use cs\Widget\FileUpload2\FileUpload;

/**
 *
 */
class ProfileTime extends BaseForm
{
    const TABLE = 'gs_users';

    public $birth_date;
    public $id;

    function __construct($fields = [])
    {
        static::$fields = [
            ['birth_date', 'Дата рождения', 1, 'cs\Widget\DatePicker\Validator',
                'widget' => ['cs\Widget\DatePicker\DatePicker']
            ],
        ];
        parent::__construct($fields);
    }
}
