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
class ProfileSubscribe extends BaseForm
{
    const TABLE = 'gs_users';

    public $id;
    public $name_first;
    public $name_last;
    public $email;
    public $password;
    public $is_admin;
    public $is_active;
    public $is_confirm;
    public $datetime_reg;
    public $datetime_activate;
    public $avatar;
    public $phone;
    public $gender;
    public $date_insert;
    public $date_update;
    public $vk_id;
    public $vk_link;
    public $fb_id;
    public $fb_link;
    public $birth_date;
    public $last_action;
    public $human_design;
    public $birth_time;
    public $birth_country;
    public $birth_town;
    public $zvezdnoe;

    public $subscribe_is_news;
    public $subscribe_is_site_update;
    public $subscribe_is_manual;
    public $subscribe_is_test;

    function __construct($fields = [])
    {
        static::$fields = [
            ['subscribe_is_news', 'Новости Планеты', 0, 'cs\Widget\CheckBox2\Validator',
                'widget' => ['cs\Widget\CheckBox2\CheckBox']
            ],
            ['subscribe_is_site_update', 'Обновления сайта', 0, 'cs\Widget\CheckBox2\Validator',
                'widget' => ['cs\Widget\CheckBox2\CheckBox']
            ],
            ['subscribe_is_manual', 'Ручные рассылки', 0, 'cs\Widget\CheckBox2\Validator',
                'widget' => ['cs\Widget\CheckBox2\CheckBox']
            ],
        ];
        parent::__construct($fields);
    }
}
