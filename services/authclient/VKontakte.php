<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 02.05.2015
 * Time: 19:36
 */

namespace app\services\authclient;


use app\models\User;
use yii\helpers\ArrayHelper;

class VKontakte extends \yii\authclient\clients\VKontakte
{
    /**
     * [
     * 'uid' => 303047598
     * 'first_name' => 'Иван'
     * 'last_name' => 'Петров'
     * 'sex' => 2
     * 'nickname' => ''
     * 'screen_name' => 'id303047598'
     * 'city' => 0
     * 'country' => 0
     * 'timezone' => 3
     * 'photo' => 'http://cs622625.vk.me/v622625598/2e7cb/bElMkYutmKQ.jpg'
     * 'id' => 303047598
     * ]
     */
    /**
     * @inheritdoc
     */
    protected function initUserAttributes()
    {
        $attributes = $this->api('users.get.json', 'GET', [
            'fields' => implode(',', [
                'uid',
                'first_name',
                'last_name',
                'nickname',
                'screen_name',
                'sex',
                'bdate',
                'city',
                'country',
                'timezone',
                'photo',
                'photo_200',
            ]),
        ]);

        return array_shift($attributes['response']);
    }

    /**
     * @param array $attributes поля выдаваемые функцией getUserAttributes();
     *
     * @return User|null
     */
    public function login($attributes)
    {
        return User::find([
            'vk_id'     => $attributes['uid'],
            'is_active' => 1,
        ]);


    }

    public function register($attributes)
    {
        $user = User::insert([
            'vk_id'             => $attributes['uid'],
            'name_first'        => $attributes['first_name'],
            'name_last'         => $attributes['last_name'],
            'gender'            => ($attributes['sex'] == 0) ? null : (($attributes['sex'] == 1) ? 0 : 1),
            'vk_link'           => $attributes['screen_name'],
            'datetime_reg'      => gmdate('YmdHis'),
            'datetime_activate' => gmdate('YmdHis'),
            'is_active'         => 1,
            'birth_date'        => $this->getBirthDate($attributes),
        ]);
        $user->setAvatarFromUrl($attributes['photo_200']);

        return $user;
    }

    /**
     * Возвращает дату рождения
     * @return string | null
     * формат 'yyyy-mm-dd'
     */
    private function getBirthDate($attributes)
    {
        $bdate = ArrayHelper::getValue($attributes, 'bdate', '');
        if ($bdate != '') {
            $arr = explode('.', $bdate);
            if (count($arr) == 3) {
                if (strlen($arr[0]) == 1) {
                    $arr[0] = '0' . $arr[0];
                }
                if (strlen($arr[1]) == 1) {
                    $arr[1] = '0' . $arr[1];
                }
                return $arr[2] . '-' . $arr[1] . '-' . $arr[0] ;
            }
        }
        return null;
    }

    /**
     * @param array            $attributes
     * @param \app\models\User $userIdentity
     */
    public function attach($attributes, $userIdentity)
    {
        $userIdentity->update([
            'vk_id'   => $attributes['uid'],
            'vk_link' => $attributes['screen_name'],
        ]);
        if (!$userIdentity->hasAvatar()) {
            $userIdentity->setAvatarFromUrl($attributes['photo_200']);
        }
    }

    public function saveToken()
    {
        $params = $this->getAccessToken()->getParams();
        \Yii::$app->cache->set("authClientCollection/{$this->defaultName()}/access_token", $params['access_token'], $params['expires_in']);
    }
} 