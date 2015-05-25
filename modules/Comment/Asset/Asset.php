<?php
/**
 * @link      http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

namespace app\modules\Comment\Asset;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since  2.0
 */
class Asset extends AssetBundle
{
    public $sourcePath  = '@app/modules/Comment/Asset/asset';
    public $css     = [
    ];
    public $js      = [
        'index.js',
    ];
    public $depends = [
        'cs\assets\Renderer\Asset'
    ];
}
