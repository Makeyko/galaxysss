$(document).ready(function () {

    // кнопка Назад
    $('#buttonBack').click(function() {
        if (formValidate()) {
            var d = new Date();
            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();
            d.setFullYear(year);
            d.setMonth(month - 1);
            d.setDate(day);
            d.setTime(d.getTime() - 60*60*24*1000);

            $('#year').val(d.getFullYear());
            $('#month').val(d.getMonth() + 1);
            $('#day').val(d.getDate());

            setAll(d);
        }
    });

    // кнопка Вперед
    $('#buttonForward').click(function() {
        if (formValidate()) {
            var d = new Date();
            var year = $('#year').val();
            var month = $('#month').val();
            var day = $('#day').val();
            d.setFullYear(year);
            d.setMonth(month - 1);
            d.setDate(day);
            d.setTime(d.getTime() + 60*60*24*1000);

            $('#year').val(d.getFullYear());
            $('#month').val(d.getMonth() + 1);
            $('#day').val(d.getDate());

            setAll(d);
        }
    });

    /**
     * Устанавливает волну
     * прописывает в таблицу #wave все печати с тонами
     *
     * @param d Date()
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

            setWave2Cell(i + 1, stamp, kin, mayaDate.ton);

            stamp++;
            kin++;
            if (stamp > 20) stamp = 1;

        });
    }

    /**
     * Устанавливает песню дня
     *
     * @param d MayaDate
     */
    function setPesnya(d) {
        var objPesnya = $('#pesnya');
        var pesnya = [
            'Я {1}, дабы {2},',
            '{3} {4}.',
            'Я опечатываю {5} {6} {7}',
            'Я ведом силой {6}.'
            ];
        var equal = [
            'ton.creativePower', // 1
            'stamp.action',      // 2
            'ton.action',        // 3
            'stamp.feature',     // 4
            'stamp.cageTime',    // 5
            'stamp.power',       // 6
            'ton.name',          // 7
        ];
        var tonToday = GSSS.calendar.maya.pesnya.ton[d.ton-1];
        var stampToday = GSSS.calendar.maya.pesnya.stamp[d.stamp-1];
        // во всех строках делаю замену
        for (var i = 0; i < pesnya.length; i++) {
            for (var j = 0; j < equal.length; j++) {
                pesnya[i] = pesnya[i].replace('{1}', tonToday.creativePower );
                pesnya[i] = pesnya[i].replace('{2}', stampToday.action );
                pesnya[i] = pesnya[i].replace('{3}', tonToday.action );
                pesnya[i] = pesnya[i].replace('{4}', stampToday.feature );
                pesnya[i] = pesnya[i].replace('{5}', stampToday.cageTime );
                pesnya[i] = pesnya[i].replace('{6}', stampToday.power );
                pesnya[i] = pesnya[i].replace('{7}', tonToday.name );
            }
        }
        if (d.nearPortal == 0) {
            pesnya.push('Я Есмь Портал Галактической Активации - войди в меня!');
        }
        if (d.nearPolar == 0) {
            var string = 'Я Есмь Полярный кин. Я {1} {2} галактический спектр';
            var v1 = '';
            var v2 = '';
            switch(d.ton) {
                case 3: v1 = 'устанавливаю';break;
                case 10: v1 = 'расширяю';break;
                case 4: v1 = 'преобразую';break;
                case 11: v1 = 'перемещаю';break;
            }
            switch (d.stamp % 4) {
                case 0: v2 = 'красный'; break;
                case 1: v2 = 'белый'; break;
                case 2: v2 = 'синий'; break;
                case 3: v2 = 'желтый'; break;
            }
            string = string.replace('{1}', v1).replace('{2}', v2);
            pesnya.push(string);
        }

        objPesnya.html(pesnya.join('<br>'));
    }


    function setWave2Cell(ton,stamp,kin, todayTon)
    {
        var objectCell = $('.wave-cell-' + ton);
        objectCell
            .html('')
            .append($('<img>', {
                src: MayaAssetUrl + '/images/ton/' + ton + '.gif',
                title: GSSS.calendar.maya.tonList[ton - 1][0],
                width: 20
            }).tooltip())
            .append($('<img>', {
                src: MayaAssetUrl + '/images/stamp3/' + stamp + '.gif',
                title: GSSS.calendar.maya.stampList[stamp - 1][0],
                width: 20
            }).tooltip())
            .append($('<div>', {title: 'Кин дня'}).html(kin).tooltip())
            .css('background-color', (todayTon == ton)? '#cccccc': '#ffffff')
        ;
    }

    // фрактал
    {
        /**
         * Устанавливает волну
         * прописывает в таблицу #wave4 все печати с тонами
         *
         * @param d Date()
         */
        function setWave4(d) {
            var mayaDate = GSSS.calendar.maya.driver1.calc([d.getDate(), d.getMonth() + 1, d.getFullYear()]);
            var objTable = $('#wave4');
            // вычисляю первую красную печать
            var firstKinSpyral = mayaDate.kin - (((mayaDate.kin % 52) == 0) ? 52 : mayaDate.kin % 52) + 1;

            for (var i = 1; i <= 52; i++) {
                setWave4Cell(firstKinSpyral + (i - 1), mayaDate.kin);
            }

        }

        /**
         * Устанавливает кин в таблицу фрактала
         *
         * @param kin - текущий кин
         * @param todayKin - кин сегодня
         */
        function setWave4Cell(kin, todayKin) {
            var stamp = kin % 20;
            if (stamp == 0) stamp = 20;
            var ton = kin % 13;
            if (ton == 0) ton = 13;
            var color = (kin - 1) % 52;
            color = parseInt(color / 13);

            switch (color) {
                case 0:
                    color = 'red';
                    break;
                case 1:
                    color = 'white';
                    break;
                case 2:
                    color = 'blue';
                    break;
                case 3:
                    color = 'yellow';
                    break;
            }
            var objectCell = $('.cell-' + color + '-' + ton);
            var title = [
                GSSS.calendar.maya.stampList[stamp - 1][0],
                'Тон: ' + ton,
                'Кин: ' + kin
            ];
            title = title.join(' ');
            objectCell
                .html('')
                .append($('<img>', {
                    src: MayaAssetUrl + '/images/stamp3/' + stamp + '.gif',
                    title: title,
                    width: 20
                }).tooltip())
                .css('background-color', (todayKin == kin) ? '#cccccc' : '#ffffff')
            ;
        }
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

        if (formValidate()) {
            d.setFullYear(year);
            d.setMonth(month - 1);
            d.setDate(day);

            setAll(d);
        }
    };

    /**
     * Проверяет форму на валидность, если есть ошибка то устанавливает ее
     *
     * @return bool
     * true - форма валидна
     * false - ошибка в форме
     */
    function formValidate()
    {
        var d = new Date();
        var year = $('#year').val();
        var month = $('#month').val();
        var day = $('#day').val();
        var monthDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if (day == '') {
            setError('Поле не может быть пустым');
            return false;
        }
        if (year == '') {
            setError('Поле не может быть пустым');
            return false;
        }
        // для високосного года
        if (month == 2) {
            if (day > 29) {
                setError('В феврале не может быть более 29 дней');
                return false;
            }
            if (day > 28) {
                if (year % 4 > 0) {
                    setError('В не високосном году только 28 дней в феврале');
                    return false;
                }
            }
        } else {
            if (day < 1) {
                setError('День не может быть отрицательным');
                return false;
            }
            if (day > monthDays[month - 1]) {
                setError('В этом месяце меньше дней чем вы указали');
                return false;
            }
        }
        setError('');

        return true;
    }

    /**
     * Устанавливает все виджеты на странице в актуальное состояние по дате
     * @param d Date
     */
    function setAll(d)
    {
        setDate(d);
        setWave(d);
        setWave4(d);
        setPesnya(GSSS.calendar.maya.driver1.calc([d.getDate(), d.getMonth() + 1, d.getFullYear()]));
    }

    function setError(message) {
        $('#error').html(message);
    }

    $('#day').on('input', functionSetDate);
    $('#month').on('change', functionSetDate);
    $('#year').on('input', functionSetDate);

    var d = new Date();

    setDate(d);
    setWave(d);
    setWave4(d);
    setPesnya(GSSS.calendar.maya.driver1.calc([d.getDate(), d.getMonth() + 1, d.getFullYear()]));
});