<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\modules\Shop\services\CheckBoxTreeMask;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath = '@app/modules/Shop/services/CheckBoxTreeMask/source';
	public $css = [
    ];
    public $js = [
        'index.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'cs\assets\Confirm\Asset',
    ];
}
