<?php
/**
 * Класс отвечает за хранение часто необходимых данных пользователей в кеше
 * Хранимые поля:
 * - id
 * - name
 * - avatar
 *
 * Хранимые поля задаются в self::getUserData()
 *
 * Лучшая функция self::find($id) Возвращает данные пользователя. Если их нет в кеше то они будут найдены в БД и закешированы
 */

namespace app\services;

use Yii;
use app\models\User;
use yii\base\Exception;

class UsersInCache
{
    const CACHE_PREFIX = 'UsersInCache/';

    /**
     * Возвращает данные пользователя если они есть в кеше
     *
     * @param $id
     *
     * @return false|array
     * [
     *      'id' => идентификатор пользователя
     *      'name' => Имя и фамилия
     *      'avatar' => '/' относительный путь к аватару
     * ]
     */
    public function get($id)
    {
        return Yii::$app->cache->get(self::CACHE_PREFIX . $id);
    }

    /**
     * Возвращает данные пользователя. Если их нет в кеше то они будут найдены в БД и закешированы
     *
     * @param $id
     *
     * @return array
     * [
     *      'id' => идентификатор пользователя
     *      'name' => Имя и фамилия
     *      'avatar' => '/' относительный путь к аватару
     * ]
     *
     * @throws \yii\base\Exception
     */
    public function find($id)
    {
        $data = Yii::$app->cache->get(self::CACHE_PREFIX . $id);
        if ($data !== false) return $data;
        $user = User::find($id);
        if (is_null($user)) {
            throw new Exception('Не найден пользователь ' . $id);
        }
        $data = $this->saveUser($user);

        return $data;
    }

    /**
     * Сохраняет текущего пользователя в кеш
     */
    public function saveMe()
    {
        /** @var \app\models\User $user */
        $user = Yii::$app->user->identity;
        $this->saveUser($user);
    }

    /**
     * @param \app\models\User $user
     * @return array
     * [
     *      'id' => идентификатор пользователя
     *      'name' => Имя и фамилия
     *      'avatar' => '/' относительный путь к аватару
     * ]
     */
    public function getUserData($user)
    {
        return [
            'id'     => $user->getId(),
            'name'   => $user->getField('name_first') . ' ' . $user->getField('name_last'),
            'avatar' => $user->getAvatar(),
        ];
    }

    /**
     * Сохраняет пользователя в кеше
     * @param array $data
     */
    public function save($data)
    {
        Yii::$app->cache->set(self::CACHE_PREFIX . $data['id'], $data);
    }

    /**
     * Сохраняет пользователя в кеше
     * @param \app\models\User $user
     * @return array
     * [
     *      'id' => идентификатор пользователя
     *      'name' => Имя и фамилия
     *      'avatar' => '/' относительный путь к аватару
     * ]
     */
    public function saveUser($user)
    {
        $data = $this->getUserData($user);
        $this->save($data);

        return $data;
    }
}