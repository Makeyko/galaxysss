<?php


namespace app\models;


use yii\helpers\ArrayHelper;

class UnionCategory extends \cs\base\DbRecord
{
    const TABLE = 'gs_unions_tree';

    /**
     * @return array gs_unions.*
     */
    public function getUnions()
    {
        return Union::query([
                'tree_node_id'      => $this->getId(),
                'moderation_status' => 1,
            ])
            ->orderBy(['sort_index' => SORT_ASC])
            ->orderBy([
                'if(sort_index is NULL, 1, 0)' => SORT_ASC,
                'sort_index'                   => SORT_ASC,
            ])
            ->all();
    }

    public function getParentId()
    {
        return $this->getField('parent_id');
    }

    /**
     * @return array
     * [
     *    'id' => 'string', ...
     * ]
     */
    public static function getRootList()
    {
        return ArrayHelper::map(self::query(['parent_id' => null])->select('id, header')->all(), 'id', 'header');
    }

    /**
     * Выдает список категорий определенной категории
     *
     * @param int|null     $id     идентификатор категории
     * @param string|array $select поля для выборки
     *
     * @return array
     */
    public static function getRows($id = null, $select = '*')
    {
        return self::query([
            'parent_id' => $id,
        ])
            ->select($select)
            ->orderBy([
                'if(sort_index is NULL, 1, 0)' => SORT_ASC,
                'sort_index'                   => SORT_ASC,
            ])
            ->all();
    }

    /**
     * Возвращает id_string по $id
     *
     * @param int $id идентификатор категории gs_unions_tree.id
     *
     * @return false|string
     * false - категория не найдена
     * string - возвращается название категории
     */
    public static function getIdStringById($id)
    {
        return self::query(['id' => $id])->select('id_string')->scalar();
    }

    /**
     * Возвращает хлебные крошки для этой категории
     * Если указан параметр то эти хлебные крошки будут добавлены в конец пути
     *
     * @param array $breadCrumbs хлебные крошки которые надо добавить в конец пути (массив объектов "хлебная крошка"    )
     * [
     *     [
     *        'url'   => array|string,
     *        'title' => string,
     *     ], ...
     * ]
     *
     * @return array
     * [
     *     [
     *        'url'   => array|string,
     *        'title' => string,
     *     ], ...
     * ]
     */
    public function getBreadCrumbs($add = null)
    {
        $direction = [
            [
                'url'  => ['direction/index'],
                'label'=> 'Сферы жизни',
            ]
        ];
        $breadCrumbs = self::getBreadCrumbs_repeat($this->getId());

        $ret = \yii\helpers\ArrayHelper::merge($direction, $breadCrumbs);
        if ($add) {
            $ret = \yii\helpers\ArrayHelper::merge($ret, $add);
        }

        return $ret;
    }

    /**
     * Получает все элементы хлемных крошет начиная от указанного и вплоть до корневого
     *
     * @param int $id идентификатор категории gs_unions_tree.id
     *
     * @return array
     * [
     *     [
     *        'url'   => array|string,
     *        'title' => string,
     *     ], ...
     * ]
     * Корневой элемент не указывается (дом)
     * и далее до указанного в переданном параметре
     * то есть порядок следования элементов в массиве от старшего к дочернему
     */
    private static function getBreadCrumbs_repeat($id)
    {
        $item = self::find($id);
        $parentId = $item->getParentId();
        if ($parentId) {
            $arr = self::getBreadCrumbs_repeat($parentId);
            $return = [[
                'url'  => ['page/category', 'id' => $item->getField('id_string')],
                'label' => $item->getField('header', ''),
            ]];

            return \yii\helpers\ArrayHelper::merge($arr, $return);
        } else {
            return [
                [
                    'url'  => '/' . $item->getField('id_string'),
                    'label' => $item->getField('header', ''),
                ]
            ];
        }
    }
}