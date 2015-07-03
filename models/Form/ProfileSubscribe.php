<?php

namespace app\models\Form;

use app\models\User;
use cs\base\BaseForm;
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

    public $subscribe_is_news;
    public $subscribe_is_site_update;
    public $subscribe_is_mailing;

    function __construct($fields = [])
    {
        static::$fields = [
            ['subscribe_is_news', 'новости Планеты', 0, 'integer'],
            ['subscribe_is_site_update', 'обновления сайта', 0, 'integer'],
        ];
        parent::__construct($fields);
    }
}
