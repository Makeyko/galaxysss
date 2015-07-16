<?php


namespace app\services\calendar\maya;

use cs\services\VarDumper;
use DateTime;

class Driver2
{
    /**
     * Вычисляет Кин дня
     *
     * @param DateTime $date
     *
     * @return int
     */
    public static function calc($date)
    {
        $date->setTimezone(new \DateTimeZone('UTC'));
        $startKin = 77;
        if ($date->format('j') == 29 && $date->format('n') == 2) {
            $date->sub(new \DateInterval('P1D'));
        }
        $dateBegin = new DateTime('2015-06-19', new \DateTimeZone('UTC'));

        if (self::isMore($dateBegin, $date)) {
            $begin = $dateBegin;
            $end = $date;
            $direction = 1;
        }
        else {
            $begin = $date;
            $end = $dateBegin;
            $direction = -1;
        }

        /** int количество дней между датами dateBegin и date */
        $allDays = self::calcDiff($begin, $end);
        $normalizedDays = $allDays;
        $ostatokKin = $normalizedDays % 260;
        $kin = ($startKin + ($direction * $ostatokKin)) % 260;
        if ($kin <= 0) $kin = 260 + $kin;

        return $kin;
    }

    /**
     * Сравнивает две даты
     * Отвечает на вопрос: вторая дата больше?
     *
     * @param DateTime $d1
     * @param DateTime $d2
     *
     * @return bool
     * true - d1 < d2
     * false - d1 > d2
     */
    public static function isMore($d1, $d2)
    {
        return (($d2->format('U') - $d1->format('U')) > 0);
    }

    /**
     * Вычисляет количество дней между датами с учетом того что нет високосного дня
     * например между датами 20-06-2015 и 21-06-2015 разница = 1 день
     *
     * @param DateTime $begin
     * @param DateTime $end
     *
     * @return int
     */
    public static function calcDiff($begin, $end)
    {
        $days = [
            31,
            28,
            31,
            30,
            31,
            30,
            31,
            31,
            30,
            31,
            30,
            31
        ];

        $endYear = (int)$end->format('Y');
        $endMonth = (int)$end->format('n');
        $endDay = (int)$end->format('j');
        $beginYear = (int)$begin->format('Y');
        $beginMonth = (int)$begin->format('n');
        $beginDay = (int)$begin->format('j');
        // в одном году
        if ($beginYear == $endYear) {
            if ($beginMonth < $endMonth) {
                $days2 = 0;
                for ($h = $beginMonth; $h < ($endMonth - 1); $h++) {
                    $days2 += $days[ $h ];
                }

                return $days2 + ($days[ $beginMonth - 1 ] - $beginDay + 1) + ($endDay - 1);
            }
            else {
                return $endDay - $beginDay;
            }
        }
        else {
            // кол-во дней до конца года начальной даты
            $startDays = 0;
            for ($i = $begin[1]; $i < 12; $i++) {
                $startDays += $days[ $i ];
            }
            $startDays += $days[ $beginMonth - 1 ] - $beginDay + 1;
            // кол-во дней до начала года конечной даты
            $finishDays = 0;
            for ($j = 0; $j < ($endMonth - 1); $j++) {
                $finishDays += $days[ $j ];
            }
            $finishDays += $endDay - 1;

            return ($endYear - $beginYear - 1) * 365 + $startDays + $finishDays;
        }
    }

} 