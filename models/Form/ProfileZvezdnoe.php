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
class ProfileZvezdnoe extends BaseForm
{
    public $data;

    function __construct($fields = [])
    {
        static::$fields = [
            ['data', 'Происхождение', 1, 'string',
            ],
        ];
        parent::__construct($fields);
    }

    public function action()
    {
        $z = new Zvezdnoe();
        $z->data = $this->data;

        /** @var \app\models\User $user */
        $user = Yii::$app->user->identity;
        $user->setZvezdnoe($z);

        return true;
    }
}
