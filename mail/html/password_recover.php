<?php
/**
 * @var $url string
 * @var $datetime string
 * @var $user \app\models\user
 */
?>
<p>Вы запросили востановление пароля</p>
<p>Пройдите по ссылке для восстановления пароля: <a href="<?= $url ?>"><?= $url ?></a></p>
<p>Данная ссылка будет действительна до <?= $datetime ?></p>