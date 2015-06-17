/**
 *
 * @param options
 * @returns {*}
 */

function ajaxJson(options) {

    return $.ajax({
        url: options.url,
        type: (typeof options.type != 'undefined') ? options.type : 'post',
        data: options.data,
        dataType: 'json',
        beforeSend: options.beforeSend,
        success: function (ret) {
            var status;
            for (i in ret) {
                if (i == 'error') status = 'error';
                if (i == 'success') status = 'success';
            }
            if (status == 'success') {
                options.success(ret.success);
                return;
            }
            if (status == 'error') {
                if (typeof options.errorScript != 'undefined') {
                    options.errorScript(ret.error);
                } else {
                    alert(ret.error);
                }
            }
        },
        error: function (ret) {
        }
    });
}

var CS = {

    /**
     * Вызывает диалоговое окно
     *
     * @param selector
     * @param options object|string|null
     * @returns {*|jQuery}
     */
    modal: function (selector, options) {
        if (typeof options == 'string') {
            return $(selector).dialog(options);
        }
        if (typeof options == 'undefined') {
            options = {};
        }
        var optionsDefault = {
            modal: true,
            width: 700,
            resizable: false,
            closeText: '',
            show: 'fadeIn',
            hide: 'fadeOut'
        };

        return $(selector).dialog(jQuery.extend(optionsDefault, options));
    },

    /**
     * Расставляет тултипы на selector
     *
     * @param selector string
     * @param options object|string|null
     * @returns {*|jQuery}
     */
    tooltip: function (selector, options) {
        if (typeof options == 'string') {
            return $(selector).dialog(options);
        }
        if (typeof options == 'undefined') {
            options = {};
        }
        var optionsDefault = {
            show: {duration: 300, effect: 'easeOutQuart'},
            hide: {duration: 100},
            position: {my: 'center top+10', at: 'center bottom'}
        };

        return $(selector).tooltip(jQuery.extend(optionsDefault, options));
    },

    /**
     * Парсит объект (object) в строку JSON
     *
     * @param object
     *
     * @returns {*}
     */
    jsonEncode: function (object) {
        return JSON.stringify(object);
    },

    /**
     * Парсит строку JSON (string) в объект
     *
     * @param string
     *
     * @returns {*}
     */
    jsonDecode: function (string) {
        return $.parseJSON(string);
    }
};


/**
 * Выводит информационное модальное окно
 * Если надо повесить событие на закрытие окна то надо добавить событие так
 *
 * @param text - string -  выводимое сообщение
 * @param closeFunction - function - функция выполняемая по закрытию окна
 */
function infoWindow(text, closeFunction) {

    $('#infoModal').html('').append($('<p>').html(text));
    $('#infoModal').magnificPopup({

        fixedContentPos: false,
        fixedBgPos: true,

        overflowY: 'auto',

        closeBtnInside: false,
        preloader: false,

        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-zoom-in',

        items: {
            src: '#infoModal', // CSS selector of an element on page that should be used as a popup
            type: 'inline'
        },
        callbacks:{
            afterClose: closeFunction
        }
    }).magnificPopup('open');

}


$(document).ready(function() {
    $("[data-toggle='tooltip']").tooltip();
});