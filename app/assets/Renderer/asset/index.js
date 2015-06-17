/**
 */
jQuery(function($) {
    var renderer = {
        render: function (selector, params) {
            var html = $(selector).html();
            $.each(params, function (i, e) {
                html = html.replace('___' + i + '___', e);
            });

            return html;
        }
    };
    $.fn.render = function(data) {

        var html = $(this).html();

        $.each(data, function (i, e) {
            do{
                html = html.replace('{' + i + '}', e);

            } while(html.indexOf('{' + i + '}') >= 0)
        });

        return html;
    };

});
