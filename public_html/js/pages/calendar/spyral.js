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

        var dateBegin = new Date();


        dateBegin.setDate(19);
        dateBegin.setMonth(6 - 1);
        dateBegin.setYear(2015);
        console.log(dateBegin);

        /** int количество дней между датами dateBegin и date */
        var allDays = GS.calendar.maya.driver1.calcDiff(dateBegin, date);
        var visokosDays = GS.calendar.maya.driver1.calcDiffVisokos(dateBegin, date);
        return visokosDays;
        var normalizedDays = allDays - visokosDays;
        var ostatokKin = normalizedDays % 260;
        var kin = (startKin + ostatokKin) % 260;

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
        return Math.floor((end.getTime() - begin.getTime()) / 24 / 60 / 60 / 1000);
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

        // проверяю есть ли високосный день от стартовой даты до начала следующего года isBeginVisokos
        var isBeginVisokos = true;

        // проверяю есть ли високосный день от конечной даты до начала текущего года конечной даты isEndVisokos
        var isEndVisokos = true;

        // вычисляю количество дней в промежутке "нормализованных годов" daysVisokosBetweenNormalizedYears
        {
            // beginYear - слудующий год от даты begin
            var beginYear = begin.getYear() + 1; // 2013
            // endYear - текущий год от даты end
            var endYear = end.getYear(); // 2085
            // incBeginYearVisokos - количество лет до високосного года от beginYear, если beginYear високосный, то incBeginYearVisokos = 0
            var incBeginYearVisokos = ((beginYear % 4) == 0) ? 0 :  beginYear + (4 - (beginYear % 4));
            // decEndYearVisokos - количество лет до високосного года от endYear назад, если endYear високосный то decEndYearVisokos = 0
            var decEndYearVisokos = ((endYear % 4) == 0) ? 0 :  endYear - (endYear % 4);
            // normalizedBeginYear - високосный год следующий от beginYear, если он не високосный. если beginYear - високосный, то normalizedBeginYear = beginYear
            var normalizedBeginYear = beginYear + incBeginYearVisokos;
            // normalizedEndYear - високосный год до endYear, если он не високосный. если endYear - високосный, то normalizedEndYear = endYear
            var normalizedEndYear = endYear - decEndYearVisokos;

            var daysVisokosBetweenNormalizedYears = (normalizedEndYear - normalizedBeginYear) / 4;
        }

        return daysVisokosBetweenNormalizedYears + (isBeginVisokos? 1 : 0) + (isEndVisokos? 1 : 0);
    }
};

$(document).ready(function () {


    var dateBegin = new Date();
    dateBegin.setDate(18);
    dateBegin.setMonth(6 - 1);
    dateBegin.setYear(2015);
    alert(GS.calendar.maya.driver1.calc(dateBegin));


});

