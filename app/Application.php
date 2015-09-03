<?php

namespace cs;

use cs\services\VarDumper;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class Application
{
    /**
     * Отправляет письмо в формате html и text
     *
     * @param string       $email   куда
     * @param string       $subject тема
     * @param string       $view    шаблон, лежит в /mail/html и /mail/text
     * @param array        $options параметры для шаблона
     * @param array|string $from    параметры отправителя
     *
     * @return boolean
     */
    public static function mail($email, $subject, $view, $options = [])
    {
        $from = \Yii::$app->params['mailer']['from'];

        /** @var \yii\swiftmailer\Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $text = $mailer->render('text/' . $view, $options, 'layouts/text');
        $html = $mailer->render('html/' . $view, $options, 'layouts/html');

        $result = \Yii::$app->mailer
            ->compose()
            ->setFrom($from)
            ->setTo($email)
            ->setSubject($subject)
            ->setTextBody($text)
            ->setHtmlBody($html)
            ->send();

        return $result;
    }

    /**
     * Кеширует даные при помощи $functionGet
     *
     * @param string    $key ключ для кеша
     * @param \Closure  $functionGet функция для получения данных кеша
     * @param mixed     $options данные которыебудут переданы в функцию $functionGet
     * @param bool      $isUseCache использовать кеш?
     *
     * @return mixed
     */
    public static function cache($key, $functionGet, $options = null, $isUseCache = true)
    {
        if ($isUseCache) {
            $cache = Yii::$app->cache->get($key);
            if ($cache === false) {
                $cache = $functionGet($options);
                Yii::$app->cache->set($key, $cache);
            }
            return $cache;
        } else {
            return $functionGet($options);
        }
    }

}