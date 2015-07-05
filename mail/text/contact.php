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
От: <?= $from['name'] ?><<?= $from['email'] ?>>
<?= $text ?>
