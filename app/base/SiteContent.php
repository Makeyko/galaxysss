<?php


namespace cs\base;

use app\services\GsssHtml;
use yii\db\Query;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class SiteContent extends DbRecord
{
    public function getImage($isScheme = false)
    {
        if ($isScheme) {
            return Url::to($this->getValue('image'), true);
        }

        return $this->getValue('image');
    }

    public function getContent()
    {
        return $this->getValue('content');
    }

    public function getHeader()
    {
        return $this->getValue('header');
    }

    /**
     * @param bool $isUseContent true - будет использовано поле `content` в случае отсутствия
     *
     * @return string
     */
    public function getDescription($isUseContent = false)
    {
        if ($isUseContent) {
            if ($this->getValue('description') == '') {
                return GsssHtml::getMiniText($this->getContent());
            }
        }

        return $this->getField('description');
    }

    public function getValue($name)
    {
        return $this->getField($name, '');
    }
}