<?php

/** $items array
 * [
 *    int => 'value'
 * ]
 *
'fieldId'    => $this->fieldId,
'fieldName'  => $this->fieldName,
'hiddenId'   => $this->hiddenId,
'hiddenName' => $this->hiddenName,
 */

?>

<div class="btn-group selectlist" data-resize="auto" data-initialize="selectlist" id="<?= $fieldId ?>-div">
    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button">
        <span class="selected-label">&nbsp;</span>
        <span class="caret"></span>
        <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php foreach($items as $k => $v) { ?>
            <li data-value="<?= $k ?>"><a href="#"><?= $v ?></a></li>
        <?php } ?>
    </ul>
    <input class="hidden hidden-field" name="<?= $fieldName ?>" id="<?= $fieldId ?>" readonly="readonly" aria-hidden="true" type="text"/>
</div>