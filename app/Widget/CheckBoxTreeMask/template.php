<?php

/**
 * params:
 * [
 *      'rows'     => [
 *                       [
 *                            'id'                 => '524'
 *                            'name'               => '123456'
 *                            ...
 *                            'selected'           => bool
 *                        ], ...
 *                    ]
 *     'formName'          => $this->model->formName(), // string
 *     'model'             => $this->model,             // \yii\base\Model
 *     'attrId'            => $this->attrId,            // attribute id
 *     'attrName'          => $this->attrName,          // attribute name
 *     'templateVariables' => []
 * ]
 */

/** @var $rows array */
/** @var $attrId string */
/** @var $attrName string */
/** @var $templateVariables array */
/** @var $model */
/** @var $formName string */
/** @var $tableName string */

?>



<ul>
    <?php
    foreach ($rows as $item) { ?>
        <li class="checkBoxTreeMaskLi">
            <input
                type="checkbox"
                id="<?= $attrId ?>-<?= $item['id'] ?>"
                name="<?= $attrName ?>[]"
                value="<?= $item['id'] ?>"
                <?= (\yii\helpers\ArrayHelper::getValue($item,'selected',false))? 'checked="checked"' : '' ?>
                >
            <label
                for="<?= $attrId ?>-<?= $item['id'] ?>"
                class="checkBoxTreeMaskLabel"
                ><?= $item['name'] ?></label>
            <a
                href="javascript:void(0);"
                class="btn btn-default btn-xs hide checkBoxTreeMaskButton"
                data-id="<?= $item['id'] ?>"
                data-table-name="<?= $tableName ?>"
                >
                <span class="glyphicon glyphicon-menu-down"></span>
                </a>
            <a
                href="javascript:void(0);"
                class="btn btn-default btn-xs hide checkBoxTreeMaskButton2"
                data-id="<?= $item['id'] ?>"
                data-table-name="<?= $tableName ?>"
                >
                <span class="glyphicon glyphicon-menu-right"></span>
                </a>
            <a
                href="javascript:void(0);"
                class="btn btn-default btn-xs hide checkBoxTreeMaskButtonRemove"
                data-id="<?= $item['id'] ?>"
                data-table-name="<?= $tableName ?>"
                >
                <span class="glyphicon glyphicon-remove"></span>
                </a>

        </li>

        <?php
            if (isset($item['nodes'])) {
                echo $this->render('template', [
                    'rows'              => $item['nodes'],
                    'formName'          => $formName,
                    'tableName'         => $tableName,
                    'model'             => $model,
                    'attrId'            => $attrId,
                    'attrName'          => $attrName,
                    'templateVariables' => $templateVariables,
                ]);
            }
        ?>

    <?php } ?>
</ul>
