<?php
/**
 * Facebook
 *
 * clientInfo
 * [
 * 'id' => '1395528674105616'
 * 'email' => 'authclients@galaxysss.ru'
 * 'first_name' => 'Ivan'
 * 'gender' => 'male'
 * 'last_name' => 'Vas'
 * 'link' => 'https://www.facebook.com/app_scoped_user_id/1395528674105616/'
 * 'locale' => 'ru_RU'
 * 'name' => 'Ivan Vas'
 * 'timezone' => 3
 * 'updated_time' => '2015-05-02T16:04:48+0000'
 * 'verified' => true
 * ]
 */

namespace app\services\authclient;


use app\models\User;
use cs\services\VarDumper;
use yii\helpers\ArrayHelper;

class Facebook extends \yii\authclient\clients\Facebook implements authClientInterface
{
    /**
     * @param array $attributes поля выдаваемые функцией getUserAttributes();
     *
     * @return User|null
     */
    public function login($attributes)
    {
        return User::find([
            'fb_id'     => $attributes['id'],
            'is_active' => 1,
        ]);
    }

    public function register($attributes)
    {
        $fields = [
            'fb_id'                    => $attributes['id'],
            'datetime_reg'             => gmdate('YmdHis'),
            'datetime_activate'        => gmdate('YmdHis'),
            'is_active'                => 1,
        ];
        if (ArrayHelper::getValue($attributes, 'first_name', '') != '') {
            $fields['name_first'] = ArrayHelper::getValue($attributes, 'first_name', '');
            $fields['name_last'] = ArrayHelper::getValue($attributes, 'last_name', '');
        } else {
            $fields['name_first'] = $attributes['name'];
        }
        if (ArrayHelper::getValue($attributes, 'fb_link', '') != '') {
            $fields['fb_link'] = $attributes['link'];
        }
        if (ArrayHelper::getValue($attributes, 'fb_link', '') != '') {
            $fields['gender'] = (($attributes['gender'] == 'male') ? 1 : 0);
        }
        // добавляю поля для подписки
        foreach(\app\services\Subscribe::$userFieldList as $field) {
            $fields[$field] = 1;
        }
        if (isset($attributes['email'])) {
            $fields['email'] = $attributes['email'];
            $fields['is_confirm'] = 1;
        }
        $user = User::insert($fields);
        $user->setAvatarFromUrl('https://graph.facebook.com/'.$attributes['id'].'/picture?type=large', 'jpg');

        return $user;
    }

    /**
     * Прикрепяет профиль фейсбука к профилю сайта
     *
     * @param array            $attributes
     * @param \app\models\User $userIdentity
     */
    public function attach($attributes, $userIdentity)
    {
        \Yii::info(\yii\helpers\VarDumper::dumpAsString([$attributes, $userIdentity]), 'gs\\user');
        $fields = [
            'fb_id'   => $attributes['id'],
            'fb_link' => $attributes['link'],
        ];
        if ($userIdentity->getEmail() == '') {
            if (ArrayHelper::getValue($attributes, 'email', '') != '') {
                $fields['email'] = $attributes['email'];
            }
            $fields['is_confirm'] = 1;
        }
        $userIdentity->update($fields);
        if (!$userIdentity->hasAvatar()) {
            $userIdentity->setAvatarFromUrl('https://graph.facebook.com/' . $attributes['id'] . '/picture?type=large', 'jpg');
        }
    }

    public function saveToken()
    {
        /**
         * [
        'access_token' => 'CAAP1ZASnM3tkBABIdews8OfeSh00NSyZCoSA13GvIZBtPErtxdhNA4NooM1w24NDP5OtoViYB4TZBsPA0cz6gwu2UbYBO4l6uaGyND2cAucYE6MLnrDRvYyqAI4sH5luZAPopoF8arQfMvxtGtQLsV9hG36cumhZAU40B4fiiaZA5sKiFE7W3wahwNm3Qbsa0GZCp91ZCgyyRV5ZBIVFzxPl0A'
        'expires' => '5181019'
        ]
         */
        $params = $this->getAccessToken()->getParams();
        \Yii::$app->cache->set("authClientCollection/{$this->defaultName()}/access_token", $params['access_token'], $params['expires']);
    }

    /**
     * @inheritdoc
     */
    public function setAuthFlag()
    {
        \Yii::$app->session->set('auth/' . $this->defaultName() . '/isLogin', 1);
    }

    /**
     * @inheritdoc
     */
    public function isAuthorize()
    {
        $value = \Yii::$app->session->get('auth/' . $this->defaultName() . '/isLogin', null);
        if (is_null($value)) return false;

        return ($value == 1);
    }

    /**
     * @inheritdoc
     */
    public function unLink($userIdentity)
    {
        $userIdentity->update([
            'fb_id'   => null,
            'fb_link' => null,
        ]);

        return true;
    }
}