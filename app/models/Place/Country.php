<?php

namespace cs\models\Place;

use app\models\BaseModel;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use cs\models\DbRecord;

/** Описывает объект страны */
class Country extends DbRecord
{
    const TABLE = 'cs_place_country_list';
    /**
     * Возвращает название страны
     * @return string название страны
     */
    function getName()
    {
        return $this->fields['name'];
    }

    /**
     * Возвращает список регионов этой страны
     * @return array ['id' => 'name']
     */
    public function getRegionsRows()
    {
        return (new Query())
            ->select('*')
            ->from('cs_place_region_list')
            ->where([
                'country_id' => $this->getId()
            ])
            ->all();
    }

    /**
     * Возвращает список регионов этой страны
     * @return array ['id' => 'name']
     */
    public function getRegions()
    {
        return ArrayHelper::map($this->getRegionsRows(), 'id', 'name');
    }

    /**
     * проверяет присутствует ли регион указанный в параметре среди дочерних регионов этой страны
     * @param integer $id идентификатор региона
     * @return boolean
     * true - присутствует
     * false - не присутствует
     */
    public function inRegions($id)
    {
        $regions = $this->getRegions();
        return in_array($id, array_keys($regions));
    }

    /**
     * Возвращает список стран
     * @return array [[
     * 'id' => 1
     * 'name' => 'dsd'
     * ], ...]
     */
    public static function getListRows()
    {
        return (new Query())
            ->select('*')
            ->from('cs_place_country_list')
            ->all();
    }

    /**
     * Возвращает список стран
     * @return array ['id' => 'name', ...]
     */
    public static function getList()
    {
        return ArrayHelper::map(self::getListRows(), 'id', 'name');
    }

    /**
     * Производит поиск по первым символам региона
     * @return array [
     *               'id' => int
     *               'value' => string
     * ]
     */
    public static function findAll($term) {
        return (new Query())
            ->select([
                'cs_place_country_list.id',
                'cs_place_country_list.name as value'
            ])
            ->from('cs_place_country_list')
            ->where(['like', 'cs_place_country_list.name', $term . '%', false])
            ->limit(10)
            ->orderBy('cs_place_country_list.id')
            ->all();
    }
}