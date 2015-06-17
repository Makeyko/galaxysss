<?php

namespace app\services;

use cs\services\VarDumper;
use Yii;
use Detection\MobileDetect;

/**
 * DeviceDetect
 * Параметры кешируются в сессии self::SESSION_CACHE_KEY
 *
 * @property $setParams если true автоматически устанавливает переменную \Yii::$app->params['devicedetect'] перед каждым REQUEST
 *
 */
class DeviceDetect extends \yii\base\Component
{
    const SESSION_CACHE_KEY = 'app\services\DeviceDetect::getParamsCached';

    private $_mobileDetect;

    // если true автоматически устанавливает переменную \Yii::$app->params['devicedetect'] перед каждым REQUEST
    public $setParams = true;

    public function init()
    {
        parent::init();

        if ($this->setParams) {
            \Yii::$app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
                \Yii::$app->params['devicedetect'] = $this->getParamsCached();
            });
        }
    }

    /**
     * Выдает параметры
     * [
     * 'isMobile' =>
     * 'isTablet' =>
     * 'isDesktop' =>
     * ]
     */
    public function getParams()
    {
        $params = [
            'isMobile' => $this->getMobileDetect()->isMobile(),
            'isTablet' => $this->getMobileDetect()->isTablet()
        ];
        $params['isDesktop'] = !$params['isMobile'] && !$params['isTablet'];

        return $params;
    }

    /**
     * Выдает закешированные параметры
     *
     * @return array
     */
    public function getParamsCached()
    {
        $params = Yii::$app->session->get(self::SESSION_CACHE_KEY);
        if (is_null($params)) {
            $params = $this->getParams();
            Yii::$app->session->set(self::SESSION_CACHE_KEY, $params);
        }

        return $params;
    }

    /**
     * @return MobileDetect
     */
    public function getMobileDetect()
    {
        if (is_null($this->_mobileDetect)) {
            $this->_mobileDetect = new MobileDetect();
        }

        return  $this->_mobileDetect;
    }

    public function isMobile()
    {
        return $this->getParamsCached()['isMobile'];
    }

    public function isTablet()
    {
        return $this->getParamsCached()['isTablet'];
    }

    public function isDesktop()
    {
        return $this->getParamsCached()['isDesktop'];
    }
}
