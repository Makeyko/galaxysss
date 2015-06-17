<?php

namespace app\services\authclient;

interface authClientInterface
{

    public function register($attributes);

    /**
     * Прикрепяет профиль фейсбука к профилю сайта
     *
     * @param array            $attributes
     * @param \app\models\User $userIdentity
     */
    public function attach($attributes, $userIdentity);


    public function saveToken();

    /**
     * @param array $attributes поля выдаваемые функцией getUserAttributes();
     *
     * @return \app\models\User|null
     */
    public function login($attributes);

    /**
     * Устанавливает флаг авторизации
     */
    public function setAuthFlag();

    /**
     * Возвращает ответ на вопрос "Авторизовался ли пользователь в удаленной системе OAuth?"
     * @return bool
     */
    public function isAuthorize();


} 