<?php

namespace app\models;

use app\services\RegistrationDispatcher;
use cs\services\Security;
use cs\services\SitePath;
use cs\services\VarDumper;
use Imagine\Image\Box;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use cs\services\UploadFolderDispatcher;
use yii\imagine\Image;

class User extends \cs\base\DbRecord implements \yii\web\IdentityInterface
{
    use UserCache;

    const TABLE = 'gs_users';

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find($id);
    }

    /**
     * Заполнены ли данные о Дизайне Человека?
     *
     * @return bool
     */
    public function hasHumanDesign()
    {
        return $this->getField('human_design', '') != '';
    }

    /**
     * Заполнены ли данные о Дизайне Человека?
     *
     * @return \app\models\HumanDesign
     */
    public function getHumanDesign()
    {
        $data = $this->getField('human_design_data');;
        if (is_null($data)) {
            return null;
        }
        $data = json_decode($data);

        return new \app\models\HumanDesign($data);
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
        return md5($this->getEmail() . '12345');
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() == $authKey;
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
     * Регистрирует пользователей
     *
     * @param $email
     * @param $password
     *
     * @return static
     */
    public static function registration($email, $password)
    {
        $email = strtolower($email);
        $fields = [
            'email'                    => $email,
            'password'                 => self::hashPassword($password),
            'is_active'                => 0,
            'is_confirm'               => 0,
            'datetime_reg'             => gmdate('YmdHis'),
        ];
        // добавляю поля для подписки
        foreach(\app\services\Subscribe::$userFieldList as $field) {
            $fields[$field] = 1;
        }
        \Yii::info('REQUEST: ' . \yii\helpers\VarDumper::dumpAsString($_REQUEST), 'gs\\user_registration');
        \Yii::info('Поля для регистрации: ' . \yii\helpers\VarDumper::dumpAsString($fields), 'gs\\user_registration');
        $user = self::insert($fields);
        $fields = RegistrationDispatcher::add($user->getId());
        \cs\Application::mail($email, 'Подтверждение регистрации', 'registration', [
            'url'      => Url::to([
                'auth/registration_activate',
                'code' => $fields['code']
            ], true),
            'user'     => $user,
            'datetime' => \Yii::$app->formatter->asDatetime($fields['date_finish'])
        ]);

        return $user;
    }

    public function activate()
    {
        $this->update([
            'is_active'         => 1,
            'is_confirm'        => 1,
            'datetime_activate' => gmdate('YmdHis'),
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
        $path->add('avatar.' . $extension);

        file_put_contents($path->getPathFull(), $content);
        $this->update([
            'avatar' => $path->getPath(),
        ]);

        return $path;
    }

    /**
     * Устанавливает новый аватар из адреса интернет
     *
     * @param string $url       полный url на картинку, может быть прямоугольной
     * @param string $extension расширение которое должно быть в результируеющем файле
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
        \Yii::info(\yii\helpers\VarDumper::dumpAsString($url), 'gs\\user');
        $image = new Image();
        $imageFileName = \Yii::getAlias('@runtime/temp_images');
        FileHelper::createDirectory($imageFileName);
        $imageFileName .= DIRECTORY_SEPARATOR . time() . '_' . Security::generateRandomString(10) . '.' . $extension;
        \Yii::info(\yii\helpers\VarDumper::dumpAsString($imageFileName), 'gs\\user');
        $image->getImagine()->load(file_get_contents($url))->thumbnail(new Box(300, 300))->save($imageFileName, ['format' => 'jpg', 'quality' => 100]);

        return $this->setAvatarAsContent(file_get_contents($imageFileName), $extension);
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
            return \Yii::$app->assetManager->getBundle('app\assets\App\Asset')->baseUrl . '/images/iam.png';
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
        return $this->getString('email');
    }

    /**
     * Возвращает значение из $this->fields, если значение = null то возвращается пустая строка
     *
     * @param $name
     *
     * @return mixed
     */
    public function getString($name)
    {
        return ArrayHelper::getValue($this->fields, $name, '');
    }

    /**
     * Пользователь админ?
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->getField('is_admin', 0) == 1;
    }
}
