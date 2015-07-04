<?php
/**
 * @var $item \app\models\Chenneling
 * @var $user \app\models\user
 */

use yii\helpers\Html;
use app\services\GsssHtml;

$content = $item->getField('description');
$content = $content . '';
if ($content == '') {
    $content = Html::tag('p', GsssHtml::getMiniText($item->getField('content')));
}
?>

<h1><?= $item->getName() ?></h1>
<p><img src="<?= $item->getImage(true) ?>"/></p>
<?= $content ?>
<p><a href="<?= $item->getLink(true) ?>" style="
            text-decoration: none;
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
             display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
">Читать далее</a></p>