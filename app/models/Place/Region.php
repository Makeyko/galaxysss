<?php

namespace cs\models\Place;

use app\models\BaseModel;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use cs\models\DbRecord;

class Region extends DbRecord
{
    const TABLE = 'cs_place_region_list';
    /*
        * Возвращает название региона
        * @return string название региона
        * */
    function getName()
    {
        return $this->fields['name'];
    }

    /**
     * Возвращает идентификатор страны
     * @return integer идентификатор страны
     * */
    public function getCountryId()
    {
        return $this->fields['country_id'];
    }


    /**
     * Возвращает список городов этого района
     * @return array [
     * [
     * 'id' => 1
     * 'name' => 'dd',
     * ],
     * ...
     * ]
     * */
    public function getTownsRows()
    {
        return (new Query())
            ->select('*')
            ->from('cs_place_town_list')
            ->where([
                'region_id' => $this->getId()
            ])
            ->all();
    }

    /**
     * Возвращает список городов этого района
     * @return array ['id' => 'name']
     * */
    public function getTowns()
    {
        return ArrayHelper::map($this->getTownsRows(), 'id', 'name');
    }

    /**
     * Проверяет присутствует ли город указанный в параметре среди дочерних городов этого региона
     *
     * @param integer $id идентификатор города
     *
     * @return boolean
     * true - присутствует
     * false - не присутствует
     */
    public function inTowns($id)
    {
        $towns = $this->getTowns();

        return in_array($id, array_keys($towns));
    }
	
	/**
	 * Производит поиск региона по первым введённым буквам названия
	 * @param string $term - первые буквы названия региона
	 * @param integer $country - ID страны
	 * @return array - найденные регионы
	 *		[{id: int, value: str, country_id: int, country_name: str}, {...}, ...]
	 */
	public static function findAll($term, $country) {
		$search = trim($term);
		if($search) {
			$countryId = (int) trim($country);
			$query = (new Query())
				->select([
					'cs_place_region_list.id',
					'cs_place_region_list.country_id',
					'cs_place_country_list.name AS country_name',
					'CONCAT(cs_place_region_list.name, \'. \', cs_place_country_list.name) AS value'
				])
				->from('cs_place_region_list')
				->leftJoin('cs_place_country_list', 'cs_place_country_list.id = cs_place_region_list.country_id')
				->where(['like', 'cs_place_region_list.name', $search . '%', false])
				->limit(10)
				->orderBy('cs_place_region_list.id');
			if($countryId > 0) {
				$query->andWhere(['cs_place_region_list.country_id' => $countryId]);
			}
			return $query->all();
		}
		return [];
	}
}