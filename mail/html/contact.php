<?php
/**
 * @var $text string
 * @var $from array
 * [
 *   'email':string
 *   'name':string
 * ]
 */
?>

<p>От: <?= $from['name'] ?><<?= $from['email'] ?>></p>

<p><?= nl2br($text); ?></p>
