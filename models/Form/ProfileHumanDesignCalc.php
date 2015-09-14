<?php

namespace app\models\Form;

use app\models\User;
use cs\base\BaseForm;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use cs\Widget\FileUpload2\FileUpload;

/**
 *
 */
class ProfileHumanDesignCalc extends BaseForm
{
    public $date;
    public $time;
    public $point;

    function __construct($fields = [])
    {
        static::$fields = [
            ['date', 'Дата рождения', 0, 'cs\Widget\DatePicker\Validator',
                'widget' => ['cs\Widget\DatePicker\DatePicker']
            ],
            ['time', 'Время рождения', 0, 'cs\Widget\TimePiker\Validator',
                'widget' => ['cs\Widget\TimePiker\TimePiker']
            ],
            ['point', 'Место рождения', 0, 'string', [], 'Достаточно указать город или область',
                'widget' => ['app\modules\HumanDesign\widget\PlaceMap\PlaceMap', [
                ]]
            ],
        ];
        parent::__construct($fields);
    }
}
