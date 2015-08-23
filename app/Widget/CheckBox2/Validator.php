<?php

namespace cs\Widget\CheckBox2;



class Validator extends \yii\validators\Validator
{
    public function validateAttribute($model, $attribute)
    {
//        if (!in_array($model->$attribute, ['USA', 'Web'])) {
            //$this->addError($model, $attribute, 'The country must be either "USA" or "Web".');
//        }
    }


    public function clientValidateAttribute($model, $attribute, $view)
    {
//        $statuses = json_encode(Status::find()->select('id')->asArray()->column());
//        $message = json_encode($this->message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//        return <<<JS
//if (!$.inArray(value, $statuses)) {
//    messages.push($message);
//}
//JS;
    }

}