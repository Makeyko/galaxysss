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
/** @var $category string */
/** @var $id int */

?>



<ul>
    <?php
    foreach ($rows as $item) {
        ?>
        <li>
            <a href="<?= \yii\helpers\Url::to(['union_shop/category',
                'id'            => $id,
                'category'      => $category,
                'shop_category' => $item['id'],
            ]) ?>"><?= $item['name'] ?></a>
        </li>

        <?php
        if (isset($item['nodes'])) {
            echo $this->render('_tree', [
                'rows'     => $item['nodes'],
                'category' => $category,
                'id'       => $id,
            ]);
        }
        ?>

    <?php } ?>
</ul>
