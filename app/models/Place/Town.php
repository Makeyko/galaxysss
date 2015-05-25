<?php

namespace cs\models\Place;

use app\models\BaseModel;
use yii\db\Query;
use yii\helpers\VarDumper;
use cs\models\DbRecord;

class Town extends DbRecord
{
    const TABLE = 'cs_place_town_list';
    protected $fields;

    public static function one($id) {
        return (new Query())
            ->select([
                "concat(cs_place_town_list.name, '. ', cs_place_country_list.name) as value"
            ])
            ->from('cs_place_town_list')
            ->innerJoin('cs_place_country_list', 'cs_place_country_list.id = cs_place_town_list.country_id')
            ->where([
                'cs_place_town_list.id' => $id
            ])
            ->scalar();
    }
	
	/**
	 * Производит поиск города по первым введённым буквам названия
	 * @param string $term - первые буквы названия города
	 * @param integer $country - ID страны
	 * @param integer $region - ID региона
	 * @return array - найденные города
	 *		[{id: int, value: str, country_id: int, country_name: str, region_id: int, region_name: str}, {...}, ...]
	 */
	public static function findAll($term, $country, $region) {
		$search = trim($term);
		if($search) {
			$countryId = (int) trim($country);
			$regionId = (int) trim($region);
			$query = (new Query())
				->select([
					'cs_place_town_list.id',
					'concat(cs_place_town_list.name,\'. \',cs_place_country_list.name) as value',
					'cs_place_town_list.country_id',
					'cs_place_town_list.region_id',
					'cs_place_country_list.name as country_name'
				])
				->from('cs_place_town_list')
				->leftJoin('cs_place_country_list', 'cs_place_country_list.id = cs_place_town_list.country_id')
				->where(['like', 'cs_place_town_list.name', $search . '%', false])
				->limit(10)
				->orderBy('cs_place_town_list.id');
			if($regionId > 0) {
				$query->andWhere(['cs_place_town_list.region_id' => $regionId]);
			} elseif($countryId > 0) {
				$query->andWhere(['cs_place_town_list.country_id' => $countryId]);
			}
			if($regionId < 1) {
				$query->leftJoin('cs_place_region_list', 'cs_place_region_list.id = cs_place_town_list.region_id');
				$query->addSelect(['cs_place_region_list.name as region_name']);
			}
			return $query->all();
		}
		return [];
	}

    /*
     * Возвращает название города
     * @return string название города
     * */
    function getName()
    {
        return $this->fields['name'];
    }

    /**
     * Возвращает идентификатор региона
     * @return integer идентификатор региона
     * */
    public function getRegionId()
    {
        return $this->fields['region_id'];
    }

}
