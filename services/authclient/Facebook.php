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
            'fb_id'             => $attributes['id'],
            'fb_link'           => $attributes['link'],
            'name_first'        => $attributes['first_name'],
            'name_last'         => $attributes['last_name'],
            'gender'            => ($attributes['gender'] == '') ? null : (($attributes['gender'] == 'male') ? 1 : 0),
            'datetime_reg'      => gmdate('YmdHis'),
            'datetime_activate' => gmdate('YmdHis'),
            'is_active'         => 1,
        ];
        if (isset($attributes['email'])) {
            $fields['email'] = $attributes['email'];
        }
        $user = User::insert($fields);
        $user->setAvatarFromUrl('https://graph.facebook.com/'.$attributes['id'].'/picture?type=large');

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
        $userIdentity->update([
            'fb_id'   => $attributes['id'],
            'fb_link' => $attributes['link'],
        ]);
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
}