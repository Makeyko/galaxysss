<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\assets\Maya;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath  = '@app/assets/Maya/source';
    public $css     = [
    ];
    public $js      = [
        'maya.js',
    ];
    public $depends = [
    ];

    public function getStampSrc($stamp)
    {
        return $this->baseUrl . '/images/stamp3/' . $stamp . '.gif';
    }
}
