<?php

namespace app\services;

/**
 * Подготавливает табличные данные для вывода на график Chart.js
 * где
 *
 * @param array $rows - массив линий графиков в виде значений из таблицы не сортированный
 *                    [
 *                       [
 *                          [
 *                              'date' => 'yyyy-mm-dd'
 *                              'kurs' => float
 *                          ], ...
 *                       ], ...
 *                    ]
 * @param \DateTime $start - стартовое значение на графике
 *                           можно задать как \DateTime или string 'yyyy-mm-dd'
 *                           если значение не будет задано то будет использовано самое малое значение из тех что даны в $rows
 * @param \DateTime $end   - конечное значение на графике
 *                           можно задать как \DateTime или string 'yyyy-mm-dd'
 *                           если значение не будет задано то будет использовано самое большое значение из тех что даны в $rows
 *
 * @param bool $isExcludeWeekend - убирать выходные дни из графика?
 *                               true - в графике будут отсутствовать выходные дни (по умолчанияю)
 *                               false - в графике будут присутствовать выходные дни
 * После экспорта все линии будут идти от `$start` до `$end`, если данных в таблице не хватает то они будут
 * дозаполнены значениями null
 *
 * В результате будет получен массив
 * [
 *    'x' => array - значения подписей оси Х
 *    'y' => [
 *           []  - значения оси y для каждого Х
 *           , ...
 *     ]
 * ]
 */
use cs\services\VarDumper;
use cs\web\Exception;
use yii\base\Object;
use yii\helpers\ArrayHelper;

class GraphExporter extends Object
{
    /** @var \DateTime */
    public $start;

    /** @var \DateTime */
    public $end;

    /** @var array данные для графика */
    public $rows;

    /** @var bool исключать выходные дни */
    public $isExcludeWeekend = true;

    /**
     * @var string формат для значений оси X
     */
    public $formatX = 'd.m.Y';

    public function init()
    {
        if (is_null($this->start)) {
            $this->start = $this->getMin();
        }
        if (! ($this->start instanceof \DateTime)) {
            $this->start = new \DateTime($this->start);
        }
        if (is_null($this->end)) {
            $this->end = $this->getMax();
        }
        if (! ($this->end instanceof \DateTime)) {
            $this->end = new \DateTime($this->end);
        }
        // проверка на входящие данные
        if (!$this->compare($this->start, $this->end)) {
            throw new Exception('Дата end больше start');
        }
    }

    public function run()
    {
        $y = [];
        foreach($this->rows as $row) {
            $new = [];
            $arrayOfDate = ArrayHelper::getColumn($row, 'date');
            for ($i = new \DateTime($this->start->format('Y-m-d')); $this->compare($i, $this->end); $i->add(new \DateInterval('P1D'))) {
                $isAdd = false;
                if ($this->isExcludeWeekend) {
                    // если день не выходной (пн-пт)
                    if ($i->format('N') <= 5) {
                        $isAdd = true;
                    }
                } else {
                    $isAdd = true;
                }
                if ($isAdd) {
                    $date = $i->format('Y-m-d');
                    if (in_array($date, $arrayOfDate)) {
                        $new[] = (float)$this->getKursByDate($row, $date);
                    } else {
                        $new[] = null;
                    }
                }
            }
            $y[] = $new;
        }

        $x = [];
        for ($i = new \DateTime($this->start->format('Y-m-d')); $this->compare($i, $this->end); $i->add(new \DateInterval('P1D'))) {
            if ($this->isExcludeWeekend) {
                // если день не выходной (пн-пт)
                if ($i->format('N') <= 5) {
                    $x[] = $i->format($this->formatX);
                }
            } else {
                $x[] = $i->format($this->formatX);
            }
        }

        return [
            'x' => $x,
            'y' => $y,
        ];
    }

    /**
     * Сравнивает две даты
     *
     * @param \DateTime $d1
     * @param \DateTime $d2
     *
     * @return boolean
     * true - $d2 >= $d1
     */
    public function compare($d1, $d2)
    {
        return ($d2->format('U') - $d1->format('U')) >= 0;

    }

    /**
     * Статический метод для вызова класса
     *
     * @param array $options массив инициализируемых значений через инициализацию [[yii\base\Object]]
     *
     * @return mixed
     */
    public static function convert($options)
    {
        $item = new static($options);

        return $item->run();
    }

    /**
     * Получает минимальную дату из $rows
     *
     * @return string дата в формате 'yyyy-mm-dd'
     */
    public function getMin()
    {
        $min = null;
        foreach ($this->rows as $row) {
            if (count($row) > 0) {
                $dateArray = ArrayHelper::getColumn($row, 'date');
                sort($dateArray);
                if (is_null($min)) {
                    $min = $dateArray[0];
                } else {
                    if (!$this->compare(new \DateTime($min), new \DateTime($dateArray[0]))) {
                        $min = $dateArray[0];
                    }
                }
            }
        }

        return $min;
    }

    /**
     * Получает минимальную дату из $rows
     *
     * @return string дата в формате 'yyyy-mm-dd'
     */
    public function getMax()
    {
        $max = null;
        foreach ($this->rows as $row) {
            if (count($row) > 0) {
                $dateArray = ArrayHelper::getColumn($row, 'date');
                sort($dateArray);
                $dateArray = array_reverse($dateArray);
                if (is_null($max)) {
                    $max = $dateArray[0];
                } else {
                    if ($this->compare(new \DateTime($max), new \DateTime($dateArray[0]))) {
                        $max = $dateArray[0];
                    }
                }
            }
        }

        return $max;
    }

    /**
     * Выбирает курс по запросу date, если он не будет найден то будет возвращено null
     *
     * @param array $row массив значений
     *
     * @param string $date дата по которой выбирать
     *
     * @return float|null
     */
    function getKursByDate($row, $date)
    {
        foreach($row as $i) {
            if ($i['date'] == $date) return $i['kurs'];
        }

        return null;
    }
}