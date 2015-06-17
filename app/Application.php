<?php

namespace cs;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;

class Application
{
    /**
     * Отправляет письмо в формате html и text
     *
     * @param string $email   куда
     * @param string $subject тема
     * @param string $view    шаблон, лежит в /mail/html и /mail/text
     * @param array  $options параметры для шаблона
     *
     * @return boolean
     */
    public static function mail($email, $subject, $view, $options = [])
    {
        /** @var \yii\swiftmailer\Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $text = $mailer->render('text/' . $view, $options, 'layouts/text');
        $html = $mailer->render('html/' . $view, $options, 'layouts/html');

        $result = \Yii::$app->mailer
            ->compose()
            ->setFrom(\Yii::$app->params['mailer']['from'])
            ->setTo($email)
            ->setSubject($subject)
            ->setTextBody($text)
            ->setHtmlBody($html)
            ->send();

        return $result;
    }

    public static function checkForIp()
    {
        if (!in_array($_SERVER['HTTP_X_REAL_IP'], Yii::$app->params['allowedIpList'])) {
            $messages = [
                'В этом пространстве ведутся работы по активации ДНК, манифестации новой парадигмы реальности "Земля 4D" и построению фрактального общества звездной Семьи Любви и Света.',
                'Ваш IP: ' . $_SERVER['HTTP_X_REAL_IP'] . '.',

                'Чтобы получить доступ напишите письмо на god@galaxysss.ru.',
            ];
            throw new \cs\web\Exception(join("\r\r", $messages));
        }
    }

}