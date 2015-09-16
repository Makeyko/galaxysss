<?php

namespace app\models\Form;

use app\models\HD;
use app\models\HDtown;
use app\models\User;
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
class ProfileHumanDesignCalc extends BaseForm
{
    /** @var  \DateTime */
    public $date;
    /** @var  string */
    public $time;
    /** @var  int */
    public $country;
    /** @var  int */
    public $town;

    public function init()
    {
        $this->country = (YII_ENV_PROD)? 2907 : 687;

        /** @var \app\models\User $user */
        $user = Yii::$app->user->identity;
        $birth_date = $user->getField('birth_date');
        if ($birth_date) {
            $this->date = new \DateTime($birth_date);
        }
        $birth_time = $user->getField('birth_time');
        if ($birth_time) {
            $this->time = substr($birth_time, 0, 5);
        }
        $birth_country = $user->getField('birth_country');
        if ($birth_country) {
            $this->country = $birth_country;
        }
        $birth_town = $user->getField('birth_town');
        if ($birth_town) {
            $this->town = $birth_town;
        }
    }

    public function rules()
    {
        return ArrayHelper::merge(
            [[['town'], 'validateTown']],
            $this->rulesAdd()
        );
    }

    public function validateTown($attribute, $params)
    {
        $count = HDtown::query(['country_id' => $this->country])->count();
        if ($count > 1) {
            if ($this->town == 0) {
                $this->addError($attribute, 'Поле должно быть заполнено обязательно');
            }
        }
    }

    function __construct($fields = [])
    {
        static::$fields = [
            ['date', 'Дата рождения', 1, 'cs\Widget\DatePicker\Validator',
                'widget' => ['cs\Widget\DatePicker\DatePicker']
            ],
            ['time', 'Время рождения', 1, 'cs\Widget\TimePiker\Validator', [], 'чч:мм',
                'widget' => ['cs\Widget\TimePiker\TimePiker']
            ],
            ['country', 'Страна', 0, 'integer',
            ],
            ['town', 'Регион', 0, 'default',
            ],
        ];
        parent::__construct($fields);
    }

    public function action()
    {
        // подготавливаю данные
        $country = HD::find($this->country)->getField('name');
        $town = HDtown::find($this->town)->getField('name');
        $datetime = $this->date->format('Y-m-d') . ' ' . $this->time;

        // получаю данные Дизайна Человека
        $extractor = new \app\modules\HumanDesign\calculate\YourHumanDesignRu();
        $data = $extractor->calc(new \DateTime($datetime), $country, $town);

        // сохраняю картинку
        $url = new \cs\services\Url($data->image);
        $path = new SitePath('/upload/HumanDesign');
        $path->add([Yii::$app->user->id, 8, $url->getExtension()]);
        $path->write($url->read());
        $data->image = $path->getPath();

        // обновляю пользовтельские данные
        /** @var \app\models\User $user */
        $user = Yii::$app->user->identity;
        $fields = [
            'human_design'  => $data->getJson(),
            'birth_date'    => $this->date->format('Y-m-d'),
            'birth_time'    => $this->time . ':00',
            'birth_country' => $this->country,
            'birth_town'    => $this->town,
        ];
        $user->update($fields);


        return true;
    }
}
