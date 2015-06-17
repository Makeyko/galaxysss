<?php

/** @var $this \yii\base\View */
/** @var $type_id */
/** @var $row_id */

use app\modules\Comment\Cache as CommentCache;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$cache = new CommentCache([
    'typeId'   => $type_id,
    'rowId'    => $row_id,
    'template' => '@app/modules/Comment/views/commentsCache.php',
]);

$functionGet = function (CommentCache $class) {
    $query = \app\modules\Comment\Model::query([
        'type_id'   => $class->typeId,
        'row_id'    => $class->rowId,
        'parent_id' => null,
    ]);
    $count = $query->count();
    $html = $this->renderFile($class->template, [
        'rows'           => $query->orderBy(['date_insert' => SORT_ASC])->limit(10)->offset($count - 10)->all(),
        'countPrevision' => ($count - 10 > 0) ? $count - 10 : 0,
        'type_id'        => $class->typeId,
        'row_id'         => $class->rowId,
    ]);

    $data = [
        'html' => $html,
        'ids'  => \app\modules\Comment\Model::query([
            'type_id'   => $class->typeId,
            'row_id'    => $class->rowId,
            'parent_id' => null,
        ])->select('user_id')->groupBy('user_id')->column(),
    ];

    return $data;
};


echo $cache->getExtended($functionGet);

?>

<?php
\app\modules\Comment\Asset\Asset::register(Yii::$app->view);

if (\Yii::$app->user->isGuest) {
    echo Html::button('Войти чтобы комментировать', [
        'class' => 'btn btn-default',
        'name'  => 'contact-button',
        'style' => 'width: 100%;',
        'id'    => 'authCommentButton',
    ]);
} else {
    $model = new \app\modules\Comment\Form();

    $form = ActiveForm::begin([
        'id'                 => 'comment-form',
        'enableClientScript' => false,
    ]);
    ?>
    <?= Html::hiddenInput('type_id', $type_id) ?>
    <?= Html::hiddenInput('row_id', $row_id) ?>
    <?= Html::hiddenInput('parent_id', null) ?>
    <?= $form->field($model, 'content', ['inputOptions' => ['placeholder' => 'введите здесь свой комментарий']])->label('Содержимое', ['class' => 'hide'])->textarea(['rows' => 5]) ?>
    <div class="form-group">
        <?= Html::button('Комментировать', [
            'class' => 'btn btn-default',
            'name'  => 'contact-button',
            'style' => 'width: 100%;',
            'id'    => 'commentButton',
        ]) ?>
    </div>
    <?php ActiveForm::end();
}
?>