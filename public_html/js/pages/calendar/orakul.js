$(document).ready(function () {

    function setDate(d) {
        $('#day').val(d.getDate());
        $('#month').val(d.getMonth() + 1);
        $('#year').val(d.getFullYear());

        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();

        var todayMaya = GSSS.calendar.maya.driver1.calc([day, month, year]);

        setTon('#today .ton', todayMaya.ton);
        setStamp('#today .stamp', todayMaya.stamp);

        // аналог
        {
            var analog = 19 - ((todayMaya.stamp == 20) ? 0 : todayMaya.stamp);
            analog = (analog == 0) ? 20 : analog;

            setTon('#analog .ton', todayMaya.ton);
            setStamp('#analog .stamp', analog);
        }

        // антипод
        {
            var antipod = ((todayMaya.stamp == 20) ? 0 : todayMaya.stamp);
            antipod = parseInt(antipod) + parseInt(((antipod > 10)? -1: 1)*10);

            setTon('#antipod .ton', todayMaya.ton);
            setStamp('#antipod .stamp', antipod);
        }

        // Ведущий учитель
        {
            var vedun;

            switch (todayMaya.ton % 5) {
                case 0:
                    // + 8 печатей
                    vedun = todayMaya.stamp + 8;
                    if (vedun > 20) {
                        vedun = vedun - 20;
                    }
                    break;
                case 1:
                    // та же печать
                    vedun = todayMaya.stamp;
                    break;
                case 2:
                    // - 8 печатей
                    vedun = todayMaya.stamp - 8;
                    if (vedun <= 0) {
                        vedun = 20 + vedun;
                    }
                    break;
                case 3:
                    // + 4 печати
                    vedun = todayMaya.stamp + 4;
                    if (vedun > 20) {
                        vedun = vedun - 20;
                    }
                    break;
                case 4:
                    // - 4 печати
                    vedun = todayMaya.stamp - 4;
                    if (vedun <= 0) {
                        vedun = 20 - vedun;
                    }
                    break;
            }
            setTon('#vedun .ton', todayMaya.ton);
            setStamp('#vedun .stamp', vedun);
        }

        // Оккультный учитель
        {
            var okkult = 21 - todayMaya.stamp;
            var okkultTon = 14 - todayMaya.ton;

            setTon('#okkult .ton', okkultTon);
            setStamp('#okkult .stamp', okkult);
        }

    }

    function setTon(selector, ton) {
        $(selector).tooltip('destroy');
        $(selector).attr('src', MayaAssetUrl + '/images/ton/' + ton + '.gif');
        $(selector).attr('title', GSSS.calendar.maya.tonList[ton - 1][0]);
        $(selector).tooltip();
    }

    function setStamp(selector, stamp) {
        $(selector).tooltip('destroy');
        $(selector).attr('src', MayaAssetUrl + '/images/stamp3/' + stamp + '.gif');
        $(selector).attr('title', GSSS.calendar.maya.stampList[stamp - 1][0]);
        $(selector).tooltip();
    }

    /**
     * Устанавливает оракул из значений полей формы
     */
    var functionSetDate = function() {
        var d = new Date();
        var year = $('#year').val();
        var month = $('#month').val();
        var day = $('#day').val();
        var monthDays = [31,28,31,30,31,30,31,31,30,31,30,31];

        // проверки
        {
            if (day == '') {
                setError('Не верная дата');
                return;
            }
            if (year == '') {
                setError('Не верная дата');
                return;
            }
            // для високосного года
            if (month == 2) {
                if (day > 29) {
                    setError('Не верная дата');
                    return;
                }
                if (day > 28) {
                    if (year % 4 > 0) {
                        setError('В не високосном году только 28 дней в феврале');
                        return;
                    }
                }
            } else {
                if (month < 1) {
                    setError('Не верная дата');
                    return;
                }
                if (month > 12) {
                    setError('Не верная дата');
                    return;
                }
                if (day < 1) {
                    setError('Не верная дата');
                    return;
                }
                if (day > monthDays[month - 1]) {
                    setError('В этом месяце меньше дней чем вы указали');
                    return;
                }
            }
        }

        setError('');
        d.setFullYear(year);
        d.setMonth(month - 1);
        d.setDate(day);

        setDate(d);
    };

    function setError(message){
        $('#error').html(message);
    }

    $('#day').on('input', functionSetDate);
    $('#month').on('change', functionSetDate);
    $('#year').on('input', functionSetDate);

    var d = new Date();

    setDate(d);
});