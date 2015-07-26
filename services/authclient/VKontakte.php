<?php
/**
 * VKontakte
 *
 * После login() и attach() устанавливает флаг $app->session->set('auth/vkontakte/isLogin') в значение 1
 */

namespace app\services\authclient;


use app\models\User;
use yii\helpers\ArrayHelper;

class VKontakte extends \yii\authclient\clients\VKontakte implements authClientInterface
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
        $fields = [
            'vk_id'                    => $attributes['uid'],
            'name_first'               => $attributes['first_name'],
            'name_last'                => $attributes['last_name'],
            'gender'                   => ($attributes['sex'] == 0) ? null : (($attributes['sex'] == 1) ? 0 : 1),
            'vk_link'                  => $attributes['screen_name'],
            'datetime_reg'             => gmdate('YmdHis'),
            'datetime_activate'        => gmdate('YmdHis'),
            'is_active'                => 1,
            'is_confirm'               => 0,
            'birth_date'               => $this->getBirthDate($attributes),
        ];
        // добавляю поля для подписки
        foreach(\app\services\Subscribe::$userFieldList as $field) {
            $fields[$field] = 1;
        }
        $user = User::insert($fields);
        \Yii::info('$fields: ' . \yii\helpers\VarDumper::dumpAsString($fields), 'gs\\fb_registration');
        $user->setAvatarFromUrl($attributes['photo_200']);

        return $user;
    }

    /**
     * Возвращает дату рождения
     *
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

                return $arr[2] . '-' . $arr[1] . '-' . $arr[0];
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
            'vk_id'   => null,
            'vk_link' => null,
        ]);

        return true;
    }
}