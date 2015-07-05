$(document).ready(function () {

    /**
     * Устанавливает волну
     * прописывает в таблицу #wave все печати с тонами
     */
    function setWave(d) {
        var mayaDate = GSSS.calendar.maya.driver1.calc([d.getDate(), d.getMonth() + 1, d.getFullYear()]);
        var objTable = $('#wave');
        // вычисляю первую печать
        var stamp = mayaDate.stamp - (mayaDate.ton - 1);
        if (stamp <= 0) stamp = 20 + stamp;
        // вычисляю первый кин
        var kin = mayaDate.kin - (mayaDate.ton - 1);

        objTable.find('td').each(function(i, v) {
            var objectTd = $(v);
            if ((i + 1) == mayaDate.ton) {
                objectTd.css('background-color', '#cccccc');
            } else {
                objectTd.css('background-color', '#ffffff');
            }
            setTon2(objectTd, i + 1);
            setStamp2(objectTd, stamp);
            setKin2(objectTd, kin);
            stamp++;
            kin++;
            if (stamp > 20) stamp = 1;

        });
    }

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
            antipod = parseInt(antipod) + parseInt(((antipod > 10) ? -1 : 1) * 10);

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
            var objectOkkult = $('#okkult');

            setTon2(objectOkkult, okkultTon);
            setStamp2(objectOkkult, okkult);
        }

    }

    function setTon(selector, ton) {
        $(selector).tooltip('destroy');
        $(selector).attr('src', MayaAssetUrl + '/images/ton/' + ton + '.gif');
        $(selector).attr('title', GSSS.calendar.maya.tonList[ton - 1][0]);
        $(selector).tooltip();
    }

    function setTon2(object, ton) {
        var objectTon = object.find('.ton');

        objectTon.tooltip('destroy');
        objectTon.attr('src', MayaAssetUrl + '/images/ton/' + ton + '.gif');
        objectTon.attr('title', GSSS.calendar.maya.tonList[ton - 1][0]);
        objectTon.tooltip();
    }

    function setStamp2(object, stamp) {
        var objectStamp = object.find('.stamp');

        objectStamp.tooltip('destroy');
        objectStamp.attr('src', MayaAssetUrl + '/images/stamp3/' + stamp + '.gif');
        objectStamp.attr('title', GSSS.calendar.maya.stampList[stamp - 1][0]);
        objectStamp.tooltip();
    }

    function setKin2(object, kin) {
        var objectStamp = object.find('.kin');

        objectStamp.tooltip('destroy');
        objectStamp.html(kin);
        objectStamp.attr('title', 'Кин дня');
        objectStamp.tooltip();
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
    var functionSetDate = function () {
        var d = new Date();
        var year = $('#year').val();
        var month = $('#month').val();
        var day = $('#day').val();
        var monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        // проверки
        {
            if (day == '') {
                setError('Поле не может быть пустым');
                return;
            }
            if (year == '') {
                setError('Поле не может быть пустым');
                return;
            }
            // для високосного года
            if (month == 2) {
                if (day > 29) {
                    setError('В феврале не может быть более 29 дней');
                    return;
                }
                if (day > 28) {
                    if (year % 4 > 0) {
                        setError('В не високосном году только 28 дней в феврале');
                        return;
                    }
                }
            } else {
                if (day < 1) {
                    setError('День не может быть отрицательным');
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

        console.log(d);
        setDate(d);
        console.log(d);
        setWave(d);
    };

    function setError(message) {
        $('#error').html(message);
    }

    $('#day').on('input', functionSetDate);
    $('#month').on('change', functionSetDate);
    $('#year').on('input', functionSetDate);

    var d = new Date();

    setDate(d);
    setWave(d);
});