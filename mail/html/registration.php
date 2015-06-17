<?php
/**
 * @var $url string
 * @var $datetime string
 * @var $user \app\models\user
 */
?>

<p>Вы попали в новую вселенную «Мы желаем всем счастья».</p>
<p>Добро пожаловать в новый мир счастья, радости и процветания!</p>
<p>Чтобы подтвердить свое желания стать частью нового мира, нажмите кнопку ниже.</p>
<p><a href="<?= $url ?>" style="
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
">Ссылка</a></p>

<p>Данная ссылка будет действительна до <?= $datetime ?></p>