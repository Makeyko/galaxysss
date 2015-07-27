var LayoutMenu = {
    init: function(maya) {
        var d = new Date();
        var m = d.getMonth();
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

        var mStr = mArr[m];
        var y = d.getFullYear();
        var day = d.getDate();
        var dayString = day + ' ' + mStr + ' ' + y + ' г.';
        var dateTimeString = d.getFullYear() + '-' + ((m<10)?'0'+m:m) + '-' + ((day<10)?'0'+day:day) + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
        $('#dateThis').html(dayString);

        // установка popover
        if (typeof maya == 'undefined') {
            maya = GSSS.calendar.maya.driver1.calc([day, m + 1, y]);
            ajaxJson({
                url: '/calendar/save',
                data: {
                    maya: JSON.stringify(maya),
                    stamp: maya.stamp,
                    date: dayString,
                    datetime: dateTimeString
                },
                success: function(ret) {

                }
            });
            $('#calendarMayaStamp').attr('src', pathMaya + '/images/stamp3/' + maya.stamp + '.gif');
        }

        var stampItem = GSSS.calendar.maya.stampList[maya.stamp - 1];
        var objPopover = $('#calendarMayaDescription');
        objPopover.find('h4').html(stampItem[0] + ' <sup title="Тон"><abbr>' + maya.ton + '</abbr></sup>');
        $(objPopover.find('p')[0]).html(stampItem[3]);
        // ближайший портал
        switch (maya.nearPortal) {
            case 0:
                $(objPopover.find('p')[1]).html('<span class="glyphicon glyphicon-ok text-success" aria-hidden="true" style="padding-right: 5px;"></span>Сегодня <abbr title="День имеет прямую связь с духом и космосом">портал галактической активации</abbr>');
                break;
            case 1:
                $(objPopover.find('span[class="days"]')).html('завтра');
                break;
            default :
                objPopover.find('kbd').html(maya.nearPortal);
                if ($.inArray(maya.nearPortal, [2,3,4]) >= 0) {
                    $(objPopover.find('span[class="days2"]')).html('дня');
                } else {
                    $(objPopover.find('span[class="days2"]')).html('дней');
                }
                break;
        }
        $('#linkCalendar').popover({
            content: $('#calendarMayaDescription').html()
        });
        $('#linkCalendar').on('shown.bs.popover', function () {
            var idPopover = $(this).attr('aria-describedby');
            $('#' + idPopover + ' abbr').tooltip();
            $('#' + idPopover + ' sup').tooltip();
        });

    }
};


$(document).ready(function () {

    // форма подписки
    {
        function setCookie (name, value, expires, path, domain, secure) {
            document.cookie = name + "=" + escape(value) +
            ((expires) ? "; expires=" + expires : "") +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            ((secure) ? "; secure" : "");
        }
        $('#formSubscribeSubmit').click(function() {
            var object;
            object = $('#formSubscribeName');
            if (object.length > 0) {
                if (object.val() == '') {
                    object.parent().addClass('has-error').find('.help-block-error').html('Это обязательное поле').show().removeClass('hide');
                    object.focus();

                    return;
                }
            }
            object = $('#formSubscribeEmail');
            if (object.val() == '') {
                object.parent().addClass('has-error').find('.help-block-error').html('Это обязательное поле').show().removeClass('hide');
                object.focus();

                return;
            }
            ajaxJson({
                url: '/subscribe/mail',
                data: {
                    email: $('#formSubscribeEmail').val(),
                    name: $('#formSubscribeName').val()
                },
                success: function(ret) {
                    $('#formSubscribe').remove();
                    setCookie('subscribeIsStarted', 1);
                    infoWindow('Вам на почту выслано подтверждение, пройдите пожалуйста на почту');
                },
                errorScript: function(ret) {
                    object = $('#formSubscribeEmail');
                    object.parent().addClass('has-error').find('.help-block-error').html(ret.message).show().removeClass('hide');
                }
            });
        });
        $('#formSubscribeName, #formSubscribeEmail').on('input', function() {
            $(this).parent().removeClass('has-error').find('.help-block-error').hide();
        });
    }



    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,

        fixedContentPos: false
    });

    function showError(message) {
        $('#loginFormError').html(message).show();
    }
    $('.footer')
        .on('over', function() {
            $(this).css('opacity', '1');
        })
        .on('mouseover', function() {
            $(this).css('opacity', '1');
        })
        .on('blur', function() {
            $(this).css('opacity', '0.5');
        })
        .on('mouseout', function() {
            $(this).css('opacity', '0.5');
        })
    ;
    // форма авторизации
    {
        $('#modalLogin').click(function () {
            $('#loginModal').modal('show');
        });
        $('#buttonLogin').click(function () {
            if ($('#field-email').val() == '') return showError('Введите логин');
            if ($('#field-password').val() == '') return showError('Введите пароль');
            ajaxJson({
                url: '/loginAjax',
                data: {
                    email: $('#field-email').val(),
                    password: $('#field-password').val()
                },
                beforeSend: function () {
                    $('#buttonLogin').html($('#loginFormLoading').html());
                },
                success: function (ret) {
                    window.location.reload();
                },
                errorScript: function (ret) {
                    $('#buttonLogin').html('Войти');
                    $('#loginFormError').html(ret.data).show();
                }
            })
        });
        $('#field-email').on('focus', function () {
            $('#loginFormError').hide();
        });
        $('#field-password').on('focus', function () {
            $('#loginFormError').hide();
        });
        $('#field-password').on('keyup', function (event) {
            if (event.keyCode == 13) {
                $('#buttonLogin').click();
            }
        });
        $('#loginBarButton').on('mouseover', function() {
            $(this).css('opacity','1');
        });
        $('#loginBarButton').on('mouseout', function() {
            $(this).css('opacity','0.5');
        });
    }

});