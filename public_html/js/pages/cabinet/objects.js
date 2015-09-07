$(document).ready(function () {

    $('.buttonDelete').click(function (e) {
        if (confirm('Подтвердите удаление')) {
            e.preventDefault();
            var id = $(this).data('id');
            var a = $(this).parent().parent().parent();
            console.log(a);
            ajaxJson({
                url: '/objects/' + id + '/delete',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });


    // Отправить на модерацию
    $('.buttonSendModeration').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите свой выбор')) {
            var id = $(this).data('id');
            var a = $(this).parent().parent().parent();
            ajaxJson({
                url: '/objects/' + id + '/sendModeration',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });

    // Сделать рассылку
    $('.buttonAddSiteUpdate').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите')) {
            var buttonSubscribe = $(this);
            var id = $(this).data('id');
            ajaxJson({
                url: '/objects/' + id + '/subscribe',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        buttonSubscribe.remove();
                    });
                }
            });
        }
    });});