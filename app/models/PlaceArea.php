<?php

namespace cs\models;

/** Описывает область территории (страна, регион, город) */
class PlaceArea
{
    const TYPE_COUNTRY = 1;
    const TYPE_REGION  = 2;
    const TYPE_TOWN    = 3;

    const COMPARE_RESULT_EQUAL  = 1; // Полное соответствие
    const COMPARE_RESULT_MORE   = 2; // Шире
    const COMPARE_RESULT_NARROW = 3; // Уже

    private $type;
    private $id;

    public function __construct($type, $id)
    {
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * Возвращает тип области
     * @return integer тип области PlaceArea::TYPE_*
     * */
    function getType()
    {
        return $this->type;
    }

    /**
     * Возвращает id области
     * @return integer id области
     * */
    function getId()
    {
        return $this->id;
    }

    /**
     * Сравнивает переданный тип с указанным в классе
     *
     * @param integer $type тип области PlaceArea::TYPE_*
     *
     * @return integer тип соответствия PlaceArea::COMPARE_RESULT_*
     * Если тип соответствует, то возвращается PlaceArea::COMPARE_RESULT_EQUAL
     * Если тип в объекте шире переданного в функцию для сравнения, то - PlaceArea::COMPARE_RESULT_MORE
     * Если тип в объекте уже переданного в функцию для сравнения, то - PlaceArea::COMPARE_RESULT_NARROW
     * */
    public function compareType($type)
    {
        // тип места строго соответствует
        if ($type == $this->getType()) return self::COMPARE_RESULT_EQUAL;
        // тип в объекте шире переданного в функцию для сравнения
        if ($type < $this->getType()) return self::COMPARE_RESULT_MORE;
        // тип в объекте уже переданного в функцию для сравнения
        if ($type > $this->getType()) return self::COMPARE_RESULT_NARROW;

    }
}