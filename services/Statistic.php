<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 03.09.2015
 * Time: 15:00
 */

namespace app\services;


use cs\services\VarDumper;

class Statistic
{
    /**
     * Выдает данные для графика прироста пользователей на каждый день
     *
     * @param array  $rows        массив дат ['yyyy-mm-dd hh:mm:ss', ... ]
     * @param string $dateFormatX формат дат на оси X
     *
     * @return array
     * [
     *     'x' => array []
     *     'y' => array
     * ]
     */
    public static function getIncrementDataGraphic($rows, $dateFormatX = 'd.m.Y')
    {
        // вычисляю минимальное и максимальное значение
        sort($rows);
        $min = $rows[0];
        $max = $rows[count($rows) - 1];
        $maxDateTime = new \DateTime($max);
        $minDateTime = new \DateTime($min);
        $minU = (int)$minDateTime->format('U');
        $maxU = (int)$maxDateTime->format('U');
        $c = 0;
        $currentDateDT = $minDateTime;
        $currentDate = $currentDateDT->format('Y-m-d');
        $new = [];
        foreach($rows as $item) {
            if (substr($item,0,10) == $currentDate) {
                $c++;
            } else {
                $new[] = [
                    'date' => $currentDateDT->format($dateFormatX),
                    'count' => $c,
                ];
                $nextDay = (new \DateTime($currentDate))->add(new \DateInterval('P1D'))->format('Y-m-d');
                // если следующий день из массива равен следующему календарному дню?
                if ($nextDay == substr($item,0,10)) {
                    $c = 1;
                    $currentDate = $nextDay;
                    $currentDateDT = new \DateTime($currentDate);
                } else {
                    // добавляем пустые значенияю в график
                    for($i = new \DateTime($nextDay); $i->format('Y-m-d') != substr($item,0,10); $i->add(new \DateInterval('P1D'))) {
                        $new [] = [
                            'date' => $i->format($dateFormatX),
                            'count' => 0,
                        ]   ;
                    }
                    $c = 1;
                    $currentDate = substr($item,0,10);
                    $currentDateDT = new \DateTime($currentDate);
                }
            }
        }
        $new [] = [
            'date' => $currentDateDT->format($dateFormatX),
            'count' => $c,
        ];

        // преобразую $new в ['x'=>array, 'y'=>array]
        $x = [];
        $y = [];
        foreach($new as $item) {
            $x[] = $item['date'];
            $y[] = $item['count'];
        }

        return [
            'x' => $x,
            'y' => $y,
        ];
    }

    /**
     * Выдает данные для графика прироста пользователей на каждый день за весь периуд
     *
     * @param array  $rows        массив дат ['yyyy-mm-dd', ... ]
     * @param string $dateFormatX формат дат на оси X
     *
     * @return array
     * [
     *     'x' => array []
     *     'y' => array
     * ]
     */
    public static function getIncrementDataAllGraphic($rows, $dateFormatX = 'd.m.Y')
    {
        // вычисляю минимальное и максимальное значение
        sort($rows);
        $min = $rows[0];
        $max = $rows[count($rows) - 1];
        $maxDateTime = new \DateTime($max);
        $minDateTime = new \DateTime($min);
        $c = 0;
        $currentDateDT = $minDateTime;
        $currentDate = $currentDateDT->format('Y-m-d');
        $new = [];
        foreach($rows as $item) {
            if (substr($item,0,10) == $currentDate) {
                $c++;
            } else {
                $new[] = [
                    'date' => $currentDateDT->format($dateFormatX),
                    'count' => $c,
                ];
                $nextDay = (new \DateTime($currentDate))->add(new \DateInterval('P1D'))->format('Y-m-d');
                // если следующий день из массива равен следующему календарному дню?
                if ($nextDay == substr($item,0,10)) {
                    $currentDate = $nextDay;
                    $currentDateDT = new \DateTime($currentDate);
                } else {
                    // добавляем пустые значенияю в график
                    for($i = new \DateTime($nextDay); $i->format('Y-m-d') != substr($item,0,10); $i->add(new \DateInterval('P1D'))) {
                        $new [] = [
                            'date' => $i->format($dateFormatX),
                            'count' => $c,
                        ]   ;
                    }
                    $currentDate = substr($item, 0, 10);
                    $currentDateDT = new \DateTime($currentDate);
                }
            }
        }
        $new [] = [
            'date' => $currentDateDT->format($dateFormatX),
            'count' => $c,
        ];

        // преобразую $new в ['x' => array, 'y' => array]
        $x = [];
        $y = [];
        foreach($new as $item) {
            $x[] = $item['date'];
            $y[] = $item['count'];
        }

        return [
            'x' => $x,
            'y' => $y,
        ];
    }
}