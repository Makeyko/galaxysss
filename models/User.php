<?php

namespace app\models;

use app\services\RegistrationDispatcher;
use cs\services\SitePath;
use cs\services\VarDumper;
use yii\helpers\Url;
use cs\services\UploadFolderDispatcher;

class User extends \cs\base\DbRecord implements \yii\web\IdentityInterface
{
    const TABLE = 'gs_users';

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::find(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find(['email' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->getField('auth_key');
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return password_verify($password, $this->getField('password'));
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param $email
     * @param $password
     *
     * @return static
     */
    public static function registration($email, $password)
    {
        $user = self::insert([
            'email'        => $email,
            'password'     => self::hashPassword($password),
            'is_active'    => 0,
            'is_confirm'   => 0,
            'datetime_reg' => gmdate('YmdHis'),
        ]);
        $fields = RegistrationDispatcher::add($user->getId());
        \cs\Application::mail($email, 'Подтверждение регистрации', 'registration', [
            'url'         => Url::to([
                'auth/registration_activate',
                'code' => $fields['code']
            ], true),
            'user'        => $user,
            'datetime' => \Yii::$app->formatter->asDatetime($fields['date_finish'])
        ]);

        return $user;
    }

    public function activate()
    {
        $this->update([
            'is_active'  => 1,
            'is_confirm' => 1,
        ]);
    }

    /**
     * @param string $password некодированный пароль
     *
     * @return bool
     */
    public function setPassword($password)
    {
        return $this->update([
            'password' => self::hashPassword($password)
        ]);
    }

    /**
     * Устанавливает новый аватар
     * Картинка должна быть квадратной
     * Размер 300х300
     *
     * @param string $content   содержимое файла аватара
     * @param string $extension расширение файла
     *
     * @return \cs\services\SitePath
     */
    public function setAvatarAsContent($content, $extension)
    {
        $path = UploadFolderDispatcher::createFolder('FileUpload2', self::TABLE, $this->getId());
        $path->addAndCreate('small');
        $path->add('avatar.'.$extension);

        file_put_contents($path->getPathFull(), $content);
        $this->update([
            'avatar' => $path->getPath(),
        ]);

        return $path;
    }

    /**
     * Устанавливает новый аватар из адреса интернет
     *
     * @return \cs\services\SitePath
     */
    public function setAvatarFromUrl($url, $extension = null)
    {
        if (is_null($extension)) {
            $info = parse_url($url);
            $pathinfo = pathinfo($info['path']);
            $extension = $pathinfo['extension'];
        }

        return $this->setAvatarAsContent(file_get_contents($url), $extension);
    }

    /**
     * Возвращает аватар
     * Если не установлен то возвращает заглушку
     *
     * @return string
     */
    public function getAvatar($isFullPath = false)
    {
        $avatar = $this->getField('avatar');
        if ($avatar.'' == '') {
            return \Yii::$app->assetManager->getBundle(\app\assets\App\Asset::className())->baseUrl . '/images/iam.png';
        }
        return Url::to($avatar, $isFullPath);
    }

    /**
     * Имеет ли профиль аватар?
     *
     * @return bool
     * true - имеет
     * false - не имеет
     */
    public function hasAvatar()
    {
        return ($this->getField('avatar').'' != '');
    }

    /**
     * Возвращает почту
     *
     * @return string
     */
    public function getEmail()
    {
        $v = $this->getField('email');
        return (is_null($v)) ? '' : $v;
    }
}
