var GS = {
    calendar: {
        maya: {}
    }
};
GS.calendar.maya.driver1 = {

    /**
     * Вычисляет майянскую дату
     * @param date Date
     */
    calc: function (date) {
        // сегодняшняя дата 19-06-2015
        // печать 17 красная земля
        // тон 12
        // кин 77
        var startKin = 77;
        var begin, end;
        var direction; // 1 = date > dateBegin, -1 = dateBegin < date
        var dateBegin = new Date();

        dateBegin.setDate(19);
        dateBegin.setMonth(6 - 1);
        dateBegin.setYear(2015);
        console.log(dateBegin);

        if ((date.getTime() - dateBegin.getTime()) > 0) {
            begin = dateBegin;
            end = date;
            direction = 1;
        } else {
            begin = date;
            end = dateBegin;
            direction = -1;
        }

        /** int количество дней между датами dateBegin и date */
        var allDays = GS.calendar.maya.driver1.calcDiff(begin, end);
        console.log('allDays');
        console.log(allDays);

        var visokosDays = GS.calendar.maya.driver1.calcDiffVisokos(begin, end);
        console.log('visokosDays');
        console.log(visokosDays);

        var normalizedDays = allDays - visokosDays;
        console.log('normalizedDays');
        console.log(normalizedDays);

        var ostatokKin = normalizedDays % 260;
        console.log('ostatokKin');
        console.log(ostatokKin);

        var kin = (startKin + (direction * ostatokKin)) % 260;
        if (kin < 0) kin = 260 + kin;
        console.log('kin');
        console.log(kin);

        tmp1 = kin % 13;
        if (tmp1 == 0) {
            tmp1 = 13;
        }
        tmp1 = tmp1 + "";
        tmp2 = kin % 20;
        if (tmp2 == 0) {
            tmp2 = 20;
        }
        tmp2 = tmp2 + "";

        return {
            ton: tmp1,
            kin: kin,
            stamp: tmp2
        };
    },

    /**
     * Вычисляет количество дней между датами
     * например между датами 20-06-2015 и 21-06-2015 разница = 1 день
     *
     * @param begin Date
     * @param end   Date
     *
     * @return int
     */
    calcDiff: function (begin, end) {
        return Math.floor((end.getTime() - begin.getTime() + (1000 * 30)) / 24 / 60 / 60 / 1000);
    },

    /**
     * Вычисляет количество високосных дней между датами
     * например между датами 20-02-2012 и 21-06-2016 результат = 2 дня
     *
     * @param begin Date
     * @param end   Date
     *
     * @return int
     */
    calcDiffVisokos: function (begin, end) {

        // "день високоса" - 29 февраля - день добавляемый в високосный год

        // вычисляю количество високосных дней в промежутке "нормализованных годов" daysVisokosBetweenNormalizedYears
        // например если normalizedBeginYear = 2012 а normalizedEndYear = 2016 то daysVisokosBetweenNormalizedYears = 1
        var daysVisokosBetweenNormalizedYears;
        {
            // normalizedBeginYear - год даты "дня високоса" после вычисляемой вычисляемой
            var normalizedBeginYear = GS.calendar.maya.driver1.getNormalizedBeginYear(begin);
            console.log('normalizedBeginYear');
            console.log(normalizedBeginYear);

            // normalizedEndYear - год даты "дня високоса" до вычисляемой
            var normalizedEndYear = GS.calendar.maya.driver1.getNormalizedEndYear(end);
            console.log('normalizedEndYear');
            console.log(normalizedEndYear);

            if (normalizedEndYear >= normalizedBeginYear) {
                return ((normalizedEndYear - normalizedBeginYear) / 4) + 1;
            } else {
                return 0;
            }
        }
    },

    /**
     * Вычисляет ближайший високосный год до переданной даты по алгоритму
     * Если end = 2084-02-27, то normalizedEndYear = 2080
     * Если end = 2084-02-28, то normalizedEndYear = 2080
     * Если end = 2084-02-29, то normalizedEndYear = 2084
     * Если end = 2084-03-01, то normalizedEndYear = 2084

     * @param date Date
     * @returns int
     */
    getNormalizedEndYear: function(date)
    {
        var year = date.getFullYear();
        // если это високосный год?
        if (year % 4 == 0) {
            var month = date.getMonth() + 1;
            var day = date.getDate();
            if (month == 2 && day == 28) {
                return year - 4;
            }
            if (month == 2 && day == 29) {
                return year;
            }
            // дата то високосной даты
            if ((month == 2 && day < 28) || (month < 2)) {
                return year - 4;
            }
            // дата после високосной даты
            return year;
        } else {
            var decEndYearVisokos = year % 4;

            return year - decEndYearVisokos;
        }

    },

    /**
     * Вычисляет ближайший високосный год после переданной даты по алгоритму
     * Если end = 2016-02-27, то normalizedEndYear = 2016
     * Если end = 2016-02-28, то normalizedEndYear = 2016
     * Если end = 2016-02-29, то normalizedEndYear = 2020
     * Если end = 2016-03-01, то normalizedEndYear = 2020
     *
     * @param date Date
     * @returns int
     */
    getNormalizedBeginYear: function(date)
    {
        console.log('date');
        console.log(date);
        var year = date.getFullYear();
        // если это високосный год?
        if (year % 4 == 0) {
            var month = date.getMonth() + 1;
            var day = date.getDate();
            if (month == 2 && day == 28) {
                return year;
            }
            if (month == 2 && day == 29) {
                return year;
            }
            // дата то високосной даты
            if ((month == 2 && day < 28) || (month < 2)) {
                return year;
            }
            // дата после високосной даты
            return year + 4;
        } else {
            var incEndYearVisokos = 4 - (year % 4);

            return year + incEndYearVisokos;
        }

    }
};

$(document).ready(function () {


    var dateBegin = new Date();
    dateBegin.setDate(29);
    dateBegin.setMonth(2 - 1);
    dateBegin.setYear(2012);
    console.log(GS.calendar.maya.driver1.calc(dateBegin));


});

