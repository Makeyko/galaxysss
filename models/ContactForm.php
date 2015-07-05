<?php

namespace app\models;

use cs\Application;
use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Проверочный код',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::info(VarDumper::dumpAsString([$this->email => $this->name]), 'gs\\contact');
            Application::mail(
                $email,
                'Письмо с сайта galaxysss.ru: ' .$this->subject,
                'contact',
                [
                    'text' => $this->body,
                    'from' => [
                        'email' => $this->email,
                        'name'  => $this->name,
                    ],
                ]
//                , [$this->email => $this->name]
            );

            return true;
        } else {
            return false;
        }
    }
}
