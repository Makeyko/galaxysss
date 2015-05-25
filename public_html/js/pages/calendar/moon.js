var Moon = {

    pathUrlAsset: null,

    dayList: ['сб','вс','пн','вт','ср','чт','пт'],

    init: function (pathUrlAsset) {

        var img=new Image();
        img.src='/images/calendar/moon/ajax-loader.gif';
        $('#main-content').append('<p id="ajax-loader"><img src="/images/calendar/moon/ajax-loader.gif"></p>');
        this.pathUrlAsset = pathUrlAsset;
        var d = new Date();
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        var startDate = this.getStartDate(d);
        year = this.getYear(startDate);
        var html = this.render(year);

        $('#ajax-loader').remove();
        $('<h2>', {
            style: 'margin-bottom: 50px'
        }).append($('<img>', {
            src: Moon.pathUrlAsset + '/images/stamp2/' + year.monthList[0][0][0].stamp + '.jpg',
            height: 200
        })).insertBefore($('table.calendar'));
        $('table.calendar').html(html);
        $('.js-stamp').tooltip();
        var offset = $('#today').offset();
        offset = offset.top - (($(window).height() - $('#today').height()) / 2);

        $(window).scrollTo(offset , {
            duration: 500,
            onAfter: function() {
                $('#today').css('background-color', '#c0c0c0');
                $('.popup-with-zoom-anim').magnificPopup({
                    type: 'inline',

                    fixedContentPos: false,
                    fixedBgPos: true,

                    overflowY: 'auto',

                    closeBtnInside: true,
                    preloader: false,

                    midClick: true,
                    removalDelay: 300,
                    mainClass: 'my-mfp-zoom-in',

                    callbacks: {
                        beforeOpen: function(e,i) {
                            var thisDayLink = this.items[this.index];
                            var thisDayImg = $(thisDayLink.firstChild);
                            $(thisDayImg).tooltip('hide');
                            var day = thisDayImg.data('day');
                            var modalDialog = $('#small-dialog');
                            modalDialog.html('');
                            modalDialog.append($('<h1>').html(day.maya.stamp.data[0]));
                            if (typeof day.maya.dayOfMoon == 'undefined') {
                                modalDialog.append($('<p>').html('День вне времени'));
                            } else {
                                modalDialog.append($('<p>').html(day.maya.dayOfMoon + '\'' + day.maya.moon.id + '\'' + day.year));
                            }
                            modalDialog.append($('<p>').html(thisDayImg.clone()));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[1]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[2]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[3]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[4]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[5]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[6]));
                            modalDialog.append($('<p>').html(day.maya.stamp.data[7]));
                        }
                    }
                });
            }
        });

    },

    /**
     *
     * @param d Date - дата начала года 26 июля
     */
    getYear: function (d) {
        var todayString = this.getDateByFormat(new Date());
        console.log(todayString);
        var maya = Maya.calc(d.getDate(), d.getMonth() + 1, d.getFullYear());
        var kin = maya.kin;
        kin = 9;
        var ton = kin % 13;
        if (ton == 0) ton = 13;
        var stamp = kin % 20;
        if (stamp == 0) stamp = 20;
        var monthList = [];
        var dateGrisha = d;
        var moon, week, day;
        for (moon = 1; moon <= 13; moon++) {
            var weekList = [];
            for (week = 1; week <= 4; week++) {
                var dayList = [];
                for (day = 1; day <= 7; day++) {
                    dayList.push({
                        'ton': ton,
                        'kin': kin,
                        'stamp': stamp,
                        'isPortal': ($.inArray(kin, Maya.portalList) == -1) ? false : true,
                        'day': dateGrisha.getDate(),
                        'month': dateGrisha.getMonth() + 1,
                        'year': dateGrisha.getFullYear(),
                        'date': Moon.getDateByFormat(dateGrisha),
                        'isToday': (todayString == this.getDateByFormat(dateGrisha)),
                        'maya': {
                            ton: {
                                id: ton,
                                data: Maya.tonList[ton - 1]
                            },
                            stamp: {
                                id: stamp,
                                data: Maya.stampList[stamp - 1]
                            },
                            plazma: {
                                id: day,
                                data: Maya.plazmaList[day - 1]
                            },
                            week: week,
                            moon: {
                                id: moon,
                                data:  Maya.tonList[moon - 1]
                            },
                            dayOfMoon: ((week - 1)* 7) + day,
                            dayOfWeek: day
                        }
                    });
                    dateGrisha.setDate(dateGrisha.getDate() + 1);
                    if (dateGrisha.getMonth() == (2 - 1)) {
                        if (dateGrisha.getDate() == 29) {
                            dateGrisha.setDate(dateGrisha.getDate() + 1);
                        }
                    }
                    kin++;
                    if (kin > 260) kin = 1;
                    ton++;
                    if (ton == 14) ton = 1;
                    stamp = kin % 20;
                    if (stamp == 0) stamp = 20;
                }
                weekList.push(dayList);
            }
            monthList.push(weekList);
        }

        var dayOutOfTime = {
            'ton': ton,
            'kin': kin,
            'stamp': stamp,
            'isPortal': ($.inArray(kin, Maya.portalList) == -1) ? false : true,
            'day': dateGrisha.getDate(),
            'month': dateGrisha.getMonth(),
            'year': dateGrisha.getFullYear(),
            'date': Moon.getDateByFormat(dateGrisha),
            'isToday': false,
            'maya': {
                ton: {
                    id: ton,
                    data: Maya.tonList[ton - 1]
                },
                stamp: {
                    id: stamp,
                    data: Maya.stampList[stamp - 1]
                }
            }
        };

        return {
            'monthList': monthList,
            'dayOutOfTime': dayOutOfTime
        };
    },

    /**
     * Выводит дату в формате 'yyyy-mm-dd'
     * @param d
     * @returns {string}
     */
    getDateByFormat: function (d) {
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) day = '0' + day;
        if (month < 10) month = '0' + month;
        return year + '-' + month + '-' + day;
    },

    /**
     * Возвращает дату начала года
     * Если дата < 26.07 то будет возвращет прошлый год иначе этот год
     *
     * @param d
     * @returns {*}
     */
    getStartDate: function (d) {
        var dn = new Date();
        var day = d.getDate();
        var month = d.getMonth() + 1;
        if (day != 26 || month != 7) {
            if ((month < 7) || (month == 7 && day < 26)) {
                dn.setDate(26);
                dn.setMonth((7 - 1));
                dn.setFullYear(d.getFullYear() - 1);
            } else {
                dn.setDate(26);
                dn.setMonth((7 - 1));
                dn.setFullYear(d.getFullYear());
            }
            return dn;
        }
        return d;
    },

    /**
     *
     * @param year object
     *
     * @return string возвраает '<tr> ...'
     */
    render: function (year) {
        var html = [];
        $.each(year.monthList, function (moonNum, moon) {
            var i;
            html.push('<tr class="month">');
            html.push('<td>');
            html.push('<img src="' + Moon.pathUrlAsset + '/images/ton/' + (moonNum + 1) + '.gif" class="js-stamp" height="53" width="54">');
            html.push('</td>');
            html.push('<td colspan="6">');
            html.push('Месяц: ' + (moonNum + 1));
            html.push('<br>');
            html.push('Вопрос месяца: ' + Maya.tonList[moonNum][2]);
            html.push('</td>');
            html.push('</tr>');
            html.push('<tr>');
            for (i = 1; i <= 7; i++) {
                html.push('<th><img src="' + Moon.pathUrlAsset + '/images/plazma/' + i + '.png" class="js-stamp" height="20" width="20" title="' + Maya.plazmaList[i - 1].name + '"><br>'+Moon.dayList[i - 1]+'</th>');
            }
            html.push('</tr>');
            $.each(moon, function (weekNum, week) {
                var weekClass;
                switch (weekNum) {
                    case 0:
                        weekClass = 'red';
                        break;
                    case 1:
                        weekClass = 'white';
                        break;
                    case 2:
                        weekClass = 'blue';
                        break;
                    case 3:
                        weekClass = 'yellow';
                        break;
                }
                html.push('<tr class="' + weekClass + '">');
                $.each(week, function (dayNum, day) {
                    if (day.isToday) {
                        html.push('<td id="today">');
                    } else {
                        html.push('<td>');
                    }
                    html.push('<img src="' + Moon.pathUrlAsset + '/images/ton/' + day.ton + '.gif" class="js-stamp" height="23" width="23" style="margin-left: 8px;" title="' + Maya.tonList[day.ton - 1][0] + '" >');
                    html.push('<br>');
                    //html.push('<img src="' + Moon.pathUrlAsset + '/images/stamp/' + day.stamp + '.jpg" class="stampButton js-stamp" width="40" height="40" title="' + Maya.stampList[day.stamp - 1][0] + '">');
                    html.push('<a class="popup-with-zoom-anim" href="#small-dialog"><img src="' + Moon.pathUrlAsset + '/images/stamp/' + day.stamp + '.jpg" class="stampButton js-stamp" width="40" height="40" title="' + Maya.stampList[day.stamp - 1][0] + '" data-day="' + Encoder.htmlEncode(CS.jsonEncode(day)) + '"></a>');
                    html.push('<span title="' + Moon.dateFormat(day) + '" class="js-stamp dateGrisha" >' + Moon.dateFormat2(day.day, day.month)  + '</span>');
                    html.push('<br>');
                    html.push('<span class="kin">кин: </span>' + day.kin);
                    if (day.isPortal) {
                        html.push('<span title="Портал галактической активации" class="js-stamp portal" >п</span>');
                    }
                    html.push('</td>');
                });
                html.push('</tr>');
            });
        });

        // День вне времени
        var day = year.dayOutOfTime;
        html.push('<tr class="month">');
        if (day.isToday) {
            html.push('<td id="today">');
        } else {
            html.push('<td>');
        }
        html.push('<img src="' + Moon.pathUrlAsset + '/images/ton/' + day.ton + '.gif" class="js-stamp" height="23" width="23" style="margin-left: 8px;" title="' + Maya.tonList[day.ton - 1][0] + '" >');
        html.push('<br>');
        //html.push('<img src="' + Moon.pathUrlAsset + '/images/stamp/' + day.stamp + '.jpg" class="stampButton js-stamp" width="40" height="40" title="' + Maya.stampList[day.stamp - 1][0] + '">');
        html.push('<a class="popup-with-zoom-anim" href="#small-dialog"><img src="' + Moon.pathUrlAsset + '/images/stamp/' + day.stamp + '.jpg" class="stampButton js-stamp" width="40" height="40" title="' + Maya.stampList[day.stamp - 1][0] + '" data-day="' + Encoder.htmlEncode(CS.jsonEncode(day)) + '"></a>');
        html.push('<span title="' + Moon.dateFormat(day) + '" class="js-stamp dateGrisha" >' + Moon.dateFormat2(day.day, day.month)  + '</span>');
        html.push('<br>');
        html.push('<span class="kin">кин: </span>' + day.kin);
        if (day.isPortal) {
            html.push('<span title="Портал галактической активации" class="js-stamp portal" >п</span>');
        }
        html.push('</td>');
        html.push('<td colspan="6">');
        html.push('</td>');
        html.push('</tr>');


        return html.join('');
    },

    dateFormat: function (day) {
        var mArr = [
            'Янв',
            'Фев',
            'Мар',
            'Апр',
            'Май',
            'Июн',
            'Июл',
            'Авг',
            'Сен',
            'Окт',
            'Ноя',
            'Дек'
        ];

        var mStr = mArr[day.month - 1];
        var y = day.year;
        var day1 = day.day;
        return day1 + ' ' + mStr + ' ' + y + ' г.';
    },

    /**
     * Выводит дату формате 3 Май
     * @param d integer день от 1
     * @param m integer месяц от 1
     * @returns {string}
     */
    dateFormat2: function (d, m) {
        var mArr = [
            'Янв',
            'Фев',
            'Мар',
            'Апр',
            'Май',
            'Июн',
            'Июл',
            'Авг',
            'Сен',
            'Окт',
            'Ноя',
            'Дек'
        ];

        var mStr = mArr[m - 1];
        return d + ' ' + mStr;
    }
};

$(document).ready(function() {


});