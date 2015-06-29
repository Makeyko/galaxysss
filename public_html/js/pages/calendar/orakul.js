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

    }

    function setTon(selector, ton) {
        $(selector).attr('src', MayaAssetUrl + '/images/ton/' + ton + '.gif');
    }

    function setStamp(selector, stamp) {
        $(selector).attr('src', MayaAssetUrl + '/images/stamp3/' + stamp + '.gif');
    }

    /**
     * Устанавливает оракул из значений полей формы
     */
    var functionSetDate = function() {
        var d = new Date();

        d.setDate($('#day').val());
        d.setMonth($('#month').val() - 1);
        d.setFullYear($('#year').val());

        setDate(d);
    };

    $('#day').on('input', functionSetDate);
    $('#month').on('change', functionSetDate);
    $('#year').on('input', functionSetDate);

    var d = new Date();

    d.setDate(23);
    d.setMonth(12 - 1);
    d.setFullYear(1980);

    setDate(d);
});