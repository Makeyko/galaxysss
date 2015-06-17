<?php

namespace cs\models;

use cs\models\Place\Country;
use cs\models\Place\Region;
use cs\models\Place\Town;
use cs\models\PlaceArea;
use yii\helpers\VarDumper;

/**
 * Класс Place
 * Предназначен как объект описывающий местоположение например пользователя или значение таргетинга
 * Всего может храниться не более трех областей и все разного типа
 * например:
 * чтобы описать Россию
 * всего будет объект Country описывающий россию
 * чтобы описать Московскую область
 * всего будет два объекта Country, Region описывающие россию и московскую область
 * чтобы описать Москву
 * всего будет три объекта Country, Region, Town описывающие россию и московскую область и москву
 * то есть массив включает в себя последовательное уменьшение детализации области
 */
class Place
{
    const TYPE_COUNTRY = 1;
    const TYPE_REGION  = 2;
    const TYPE_TOWN    = 3;

    const COMPARE_RESULT_EQUAL  = 1; // Полное соответствие
    const COMPARE_RESULT_MORE   = 2; // Шире
    const COMPARE_RESULT_NARROW = 3; // Уже

    /** @var Country $country страна */
    protected $country = null;

    /** @var Region $country регион */
    protected $region = null;

    /** @var Town $country город */
    protected $town = null;

    /**
     * Конструктор класса который инициализирует его через countryId
     * @return Place
     * null если страна не найдена
     */
    public static function findCountry($id)
    {
        $country = Country::find($id);
        if (is_null($country)) return null;
        $instance = new Place();
        $instance->country = $country;

        return $instance;
    }

    /**
     * Конструктор класса который инициализирует его через regionId
     * @return Place
     * null если страна не найдена
     */
    public static function findRegion($id)
    {
        $region = Region::find($id);
        if (is_null($region)) return null;
        $instance = new Place();
        $instance->region = $region;

        $country = Country::find($region->getCountryId());
        if (is_null($country)) return null;
        $instance->country = $country;

        return $instance;
    }

    /**
     * Конструктор класса который инициализирует его через townId
     * @return Place
     * null если страна не найдена
     */
    public static function findTown($id)
    {
        $town = Town::find($id);
        if (is_null($town)) return null;
        $instance = new Place();
        $instance->town = $town;

        $region = Region::find($town->getRegionId());
        if (is_null($region)) return null;
        $instance->region = $region;

        $country = Country::find($region->getCountryId());
        if (is_null($country)) return null;
        $instance->country = $country;

        return $instance;
    }

    /**
     * Возвращает объект класса PlaceArea соответствующий максимальной детализации указанной области
     * Например если указаны страна, область и город то будет возвращет город
     * Если указана только страна то будет возвращена страна
     * @return PlaceArea
     */
    public function getPlaceArea()
    {
        if (!is_null($this->town)) {
            return new PlaceArea(PlaceArea::TYPE_TOWN, $this->town->getId());
        }
        if (!is_null($this->region)) {
            return new PlaceArea(PlaceArea::TYPE_REGION, $this->region->getId());
        }
        if (!is_null($this->country)) {
            return new PlaceArea(PlaceArea::TYPE_COUNTRY, $this->country->getId());
        }
    }

    /**
     * Возвращает объект класса Country
     * @return Country объект класса Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Возвращает объект класса Region
     * @return Region объект класса Region
     * null если не задан
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Возвращает объект класса Town
     * @return Town объект класса Town
     * null если не задан
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Проверяет попадает ли область указанная в параметре в область самого объекта
     *
     * @param Place $place область для проверки
     *
     * @return boolean
     * true - попадает
     * false - не попадает
     * если типы объектов одинаковые то сравнение происходит по id
     * если область в параметре имеет более широкий диапазон чем в объекте то возвращается false (например ищем регион а в объекте город)
     */
    public function isContains($place)
    {
        $thisPlaceArea = $this->getPlaceArea();
        $placePlaceArea = $place->getPlaceArea();
        switch ($thisPlaceArea->getType()) {
            case PlaceArea::TYPE_COUNTRY: {
                switch ($placePlaceArea->getType()) {
                    case PlaceArea::TYPE_COUNTRY:
                        return ($thisPlaceArea->getId() == $placePlaceArea->getId());
                    case PlaceArea::TYPE_REGION:
                        return $this->getCountry()->inRegions($placePlaceArea->getId());
                    case PlaceArea::TYPE_TOWN:
                        return $this->getCountry()->inRegions($place->getRegion()->getId());
                    default:
                        return false;
                }
            }
                break;
            case PlaceArea::TYPE_REGION: {
                switch ($placePlaceArea->getType()) {
                    case PlaceArea::TYPE_COUNTRY:
                        return false;
                    case PlaceArea::TYPE_REGION:
                        return ($thisPlaceArea->getId() == $placePlaceArea->getId());
                    case PlaceArea::TYPE_TOWN:
                        return $this->getRegion()->inTowns($placePlaceArea->getId());
                    default:
                        return false;
                }
            }
                break;
            case PlaceArea::TYPE_TOWN: {
                switch ($placePlaceArea->getType()) {
                    case PlaceArea::TYPE_COUNTRY:
                        return false;
                    case PlaceArea::TYPE_REGION:
                        return false;
                    case PlaceArea::TYPE_TOWN:
                        return ($thisPlaceArea->getId() == $placePlaceArea->getId());
                    default:
                        return false;
                }
            }
                break;
        }
    }

    /**
     * Возвращает список стран
     * @return array ['id' => 'name', ...]
     * */
    public static function getCountryList()
    {
        return Country::getList();
    }

    public function __toString() {
        return $this->getNameByTemplate();
    }

    public function getNameByTemplate() {
        $thisPlaceArea = $this->getPlaceArea();
        switch ($thisPlaceArea->getType()) {
            case PlaceArea::TYPE_COUNTRY: {
                return $this->country->getName();
            }
            case PlaceArea::TYPE_REGION: {
                return $this->region->getName() .'. ' . $this->country->getName();
            }
            case PlaceArea::TYPE_TOWN: {
                return $this->town->getName() .'. ' . $this->country->getName();
            }
        }
    }

    /**
     * Инициализирует класс через массив полей и префикс имени поля
     *
     * @param array $fields
     * @param string $prefix префикс имени поля
     *
     * @return Place|null
     */
    public static function initByFieldPrefix($fields, $prefix)
    {
        $country = $fields[ $prefix . '_country' ];
        $region = $fields[ $prefix . '_region' ];
        $town = $fields[ $prefix . '_town' ];

        return self::initByValues($country, $region, $town);
    }

    /**
     * Инициализирует класс через значения страна, регион, город
     *
     * @param integer $country
     * @param integer $region
     * @param integer $town
     *
     * @return self
     */
    public static function initByValues($country, $region, $town)
    {
        if (!is_null($town)) {
            return self::findTown($town);
        } elseif (!is_null($region)) {
            return self::findRegion($region);
        } elseif (!is_null($country)) {
            return self::findCountry($country);
        } else {
            return null;
        }
    }

    /**
     * @param \cs\base\BaseForm $model
     * @param string            $prefix
     *
     * @return Place|null
     */
    public static function initFromModel($model, $prefix)
    {
        $country = $prefix . '_country';
        $region = $prefix . '_region';
        $town = $prefix . '_town';

        $country = $model->$country;
        $region = $model->$region;
        $town = $model->$town;

        return self::initByValues($country, $region, $town);
    }
}