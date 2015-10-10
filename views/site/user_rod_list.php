<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\UnionCategory;
use yii\db\Query;

/* @var $this yii\web\View */
/* @var $items array gs_users_rod[user_id=<int>] */
/* @var $user \app\models\User */

$this->title = $user->getField('name_first');
?>
<div class="container">
    <div>
        <h1 class="page-header">
            <?= Html::encode($this->title) ?>
        </h1>

        <?= \cs\Widget\BreadCrumbs\BreadCrumbs::widget([
            'items' => [ 'Род' ],
            'home'  => [
                'name' => 'я',
                'url'  => \yii\helpers\Url::to(['site/user', 'id' => $user->getId()])
            ]
        ]) ?>
        <hr>
    </div>


    <table class="table table-striped table-hover">
        <tr>
            <th>
                #
            </th>
            <th>
                фото
            </th>
            <th>
                пол
            </th>
            <th>
                имя
            </th>
            <th>
                фамилия
            </th>
            <th>
                отчество
            </th>
            <th>
                приход
            </th>
            <th>
                уход
            </th>
        </tr>
        <?php for ($koleno = 2; $koleno <= 7; $koleno++) { ?>
            <tr>
                <td colspan="8" class="success">
                    Колено: <?= $koleno ?>
                </td>
            </tr>
            <?php for ($i = (pow(2, $koleno - 1) - 1); $i <= (pow(2, $koleno) - 2); $i++) { ?>
                <?php $userRod = new \app\models\UserRod($items[$i]); ?>
                <tr>
                    <td>
                        <?= $i ?>
                    </td>
                    <td>
                        <a href="<?= \yii\helpers\Url::to(['site/user_rod', 'rod_id' => $i, 'user_id' => $user->getId()]) ?>">
                            <img src="<?= $userRod->getImage()  ?>" width="50" class="thumbnail" style="margin-bottom: 0px;"/>
                        </a>
                    </td>
                    <td>
                        <a href="<?= \yii\helpers\Url::to(['site/user_rod', 'rod_id' => $i, 'user_id' => $user->getId()]) ?>">
                            <?= $userRod->getName()  ?>
                        </a>
                    </td>
                    <td>
                        <?php if ($userRod->getGender() == 1) { ?>
                            <span class="label label-danger">Мужчина</span>
                        <?php } else { ?>
                            <span class="label label-success">Женщина</span>
                        <?php } ?>
                    </td>
                    <td>
                        <?= $userRod->getField('name_last')  ?>
                    </td>
                    <td>
                        <?= $userRod->getField('name_middle')  ?>
                    </td>
                    <td>
                        <?= $userRod->getDateIn()  ?>
                    </td>
                    <td>
                        <?= $userRod->getDateOut()  ?>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
</div>
