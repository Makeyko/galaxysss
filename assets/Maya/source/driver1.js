
GSSS.calendar.maya.driver1 = {


    /**
     * Список кинов порталов галактической активации
     */
    portalList: [1, 22, 43, 64, 85, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 96, 77, 58, 39, 20, 88, 69, 50, 51, 72, 93,
        241, 222, 203, 184, 165, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 176, 197, 218, 239, 260, 168, 189, 210, 211, 192, 173
    ],

    /**
     * Вычисляет майянскую дату
     *
     * @param date array [day (1-31), month (1-12), year (1 - ...)]
     * @return
     * {
     *  ton: 1-13
     *  stamp: 1-20
     *  kin: 1-260
     *  nearPortal: int - количество дней до ближайшего портала (0 - сегодня)
     * }
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

        if (date[0] == 29 && date[1] == 2) {
            date[0] = 28;
        }

        dateBegin = [19, 6, 2015];

        if (GSSS.calendar.maya.driver1.compare(dateBegin, date)) {
            begin = dateBegin;
            end = date;
            direction = 1;
        } else {
            begin = date;
            end = dateBegin;
            direction = -1;
        }

        /** int количество дней между датами dateBegin и date */
        var allDays = GSSS.calendar.maya.driver1.calcDiff(begin, end);
        var visokosDays = 0;
        var normalizedDays = allDays - visokosDays;
        var ostatokKin = normalizedDays % 260;
        var kin = (startKin + (direction * ostatokKin)) % 260;
        if (kin < 0) kin = 260 + kin;

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
            stamp: tmp2,
            nearPortal: GSSS.calendar.maya.driver1.nearPortal(kin)
        };
    },

    /**
     * Вычисляет количество дней между датами с учетом того что нет високосного дня
     * например между датами 20-06-2015 и 21-06-2015 разница = 1 день
     *
     * @param begin Date
     * @param end   Date
     *
     * @return int
     */
    calcDiff: function (begin, end) {
        var days = [
            31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31
        ];

        var endYear = end[2];
        var endMonth = end[1];
        var endDay = end[0];
        var beginYear = begin[2];
        var beginMonth = begin[1];
        var beginDay = begin[0];
        // в одном году
        if (beginYear == endYear) {
            if (beginMonth < endMonth) {
                var days2 = 0;
                for (var h = beginMonth; h < (endMonth - 1); h++) {
                    days2 += days[h];
                }
                return days2 + (days[beginMonth - 1] - beginDay + 1) + (endDay - 1);
            } else {
                return endDay - beginDay;
            }
        } else {
            // кол-во дней до конца года начальной даты
            var startDays = 0;
            for (var i = begin[1]; i < 12; i++) {
                startDays += days[i];
            }
            startDays += days[begin[1] - 1] - begin[0] + 1;
            // кол-во дней до начала года конечной даты
            var finishDays = 0;
            for (var j = 0; j < (end[1] - 1); j++) {
                finishDays += days[j];
            }
            finishDays += end[0] - 1;

            return (endYear - beginYear - 1) * 365 + startDays + finishDays;
        }
    },

    compare: function (d1, d2) {

        var dd1 = new Date();
        dd1.setDate(d1[0]);
        dd1.setMonth(d1[1]);
        dd1.setFullYear(d1[2]);

        var dd2 = new Date();
        dd2.setDate(d2[0]);
        dd2.setMonth(d2[1]);
        dd2.setFullYear(d2[2]);

        return ((dd2.getTime() - dd1.getTime()) > 0);
    },


    /**
     * Вычисляет количество дней до ближайшего портала галактической активации
     *
     * @param kin кин на сегодня
     *
     * @return int количество дней до портала. 0 - сегодня портал
     */
    nearPortal: function (kin) {
        var arr = GSSS.calendar.maya.driver1.portalList.sort(function sortFunction(a, b) {
            if (a < b) return -1;
            if (a > b) return 1;
            return 0;
        });

        for (i = 0; i < arr.length; i++) {
            var item = arr[i];
            if (item == kin) return 0;
            if (item < kin && arr[i + 1] > kin) {
                return arr[i + 1] - kin;
            }
        }
    }

};


