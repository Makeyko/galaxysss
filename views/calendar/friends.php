<?php
/** @var array $days */
/** @var \Yii $app */
/** @var $this yii\web\View */
/** @var $me array[
 *  'birth_date' '2018-12-12'
 * ] будет присутствовать если пользователь авторизован
 */

use cs\helpers\Html;
use app\services\GsssHtml;
use cs\models\Calendar\Maya;
use yii\web\View;

$this->title = 'Календарь';

$this->registerJsFile('/js/pages/calendar/friends.js', [
    'depends' => [
        'app\assets\Maya\Asset',
        'yii\web\JqueryAsset',
    ]
]);

$mayaAssetUrl = Yii::$app->assetManager->getBundle('app\assets\Maya\Asset')->baseUrl;
$this->registerJs("var MayaAssetUrl='{$mayaAssetUrl}'", View::POS_HEAD);

$layoutAssetUrl = Yii::$app->assetManager->getBundle('app\assets\LayoutMenu\Asset')->baseUrl;
$this->registerJs("var LayoutAssetUrl='{$layoutAssetUrl}';", View::POS_HEAD);

?>
<div class="container">

    <div class="page-header">
        <h1>Друзья</h1>
    </div>

    <div class="row">
        <div class="col-lg-10">
            <?php if (!\Yii::$app->user->isGuest) { ?>
                <div class="hide" id="meBirthDate"><?= $me['birth_date'] ?></div>
            <?php } ?>

            <?php
            if (\Yii::$app->authClientCollection->getClient('vkontakte')->isAuthorize()) { ?>
                <button class="btn btn-default" id="buttonVkontakte">Вконтакте</button>
            <?php } else { ?>
                <p>Извините вы не авторизованы через Vk, пожалуйста зайтите через Vk</p>
            <?php } ?>

            <div id="friends" class="col-lg-8">

            </div>
        </div>
        <?= $this->render('_menu') ?>
    </div>


</div>