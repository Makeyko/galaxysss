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

<div class="input-group input-append dropdown combobox" data-initialize="combobox" id="<?= $fieldId ?>-div">
    <input type="hidden" id="<?= $hiddenId ?>" name="<?= $hiddenName ?>">
    <input type="text" class="form-control" id="<?= $fieldId ?>" name="<?= $fieldName ?>">
    <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul class="dropdown-menu dropdown-menu-right">
            <?php foreach($items as $k => $v) { ?>
                <li data-value="<?= $k ?>"><a href="#"><?= $v ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>