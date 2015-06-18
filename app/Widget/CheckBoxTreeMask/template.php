<?php

/**
 * [
 * 'rows'     => [
 * [
 * 'id'                 => '524'
 * 'name'               => '123456'
 * ...
 * 'selected'           => bool
 * ],...]
 * 'formName' => $this->model->formName(), // string
 * 'model'    => $this->model, // \yii\base\Model
 * 'attrId'   => $this->attrId, // attribute id
 * 'attrName' => $this->attrName, // attribute name
 * 'templateVariables' => []
 * ]
 *
 * Обязательные поля
 * <input type="checkbox" id="#{attrId}-check-all-input"> // поле общее для всех checkbox
 * <(label) id="'#{attrId}-check-all"> // поле на которое навешивается событие on click

 */

/** @var $rows array */
/** @var $attrId string */
/** @var $attrName string */
/** @var $templateVariables array */
/** @var $model */
/** @var $formName string */

?>



<ul>
    <?php
    foreach ($rows as $item) { ?>
        <li>
            <input type="checkbox" id="<?= $attrId ?>-<?= $item['id'] ?>" name="<?= $attrName ?>[]"
                   value="<?= $item['id'] ?>" <?= (\yii\helpers\ArrayHelper::getValue($item,'selected',false))? 'checked="checked"' : '' ?>> <label
                for="<?= $attrId ?>-<?= $item['id'] ?>"><?= $item['name'] ?></label>

        </li>

        <?php
            if (isset($item['nodes'])) {
                echo $this->render('template', [
                    'rows'              => $item['nodes'],
                    'formName'          => $formName,
                    'model'             => $model,
                    'attrId'            => $attrId,
                    'attrName'          => $attrName,
                    'templateVariables' => $templateVariables,
                ]);
            }
        ?>

    <?php } ?>
</ul>
