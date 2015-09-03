<?php


namespace cs\services;


class BitMask
{
    public $bitsCount = 64;

    protected $mask;
    protected $array;

    /**
     * @param array|int $value
     *
     */
    public function __construct($value)
    {
        if (is_array($value)) {
            $this->array = $value;
        }
        else {
            $this->mask = $value;
        }
    }

    /**
     * @param int $mask
     *
     * @return array
     */
    protected function maskToArray($mask)
    {
        $ret = [];
        for ($i = 0; $i < $this->bitsCount; $i++) {
            if (pow(2, $i) & $mask) $ret[] = $i + 1;
        }
        return $ret;
    }


    public function getMask()
    {
        if (is_null($this->mask)) {
            $this->mask = $this->arrayToMask($this->array);
        }

        return $this->mask;
    }

    public function getArray()
    {
        if (is_null($this->array)) {
            $this->array = $this->maskToArray($this->mask);
        }

        return $this->array;
    }

    /**
     * @param array $list
     *
     * @return int
     */
    protected function arrayToMask($list)
    {
        $mask = 0;
        if (is_null($list)) {
            return 0;
        }
        foreach ($list as $item) {
            $mask += pow(2, $item - 1);
        }

        return $mask;
    }

} 