$(document).ready(function () {

    $('.buttonDelete').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите удаление')) {
            var id = $(this).data('id');
            ajaxJson({
                url: '/admin/chennelingList/' + id + '/delete',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        $('#newsItem-' + id).remove();
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
                url: '/admin/chennelingList/' + id + '/subscribe',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        buttonSubscribe.remove();
                    });
                }
            });
        }
    });
});