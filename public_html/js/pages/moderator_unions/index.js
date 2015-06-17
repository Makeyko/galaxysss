$(document).ready(function () {

    $('.buttonAccept').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите')) {
            var id = $(this).data('id');
            var a = $(this).parent().parent().parent();
            ajaxJson({
                url: '/moderator/unionList/' + id + '/accept',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });

    $('.buttonReject').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите')) {
            var id = $(this).data('id');
            var a = $(this).parent().parent().parent();
            ajaxJson({
                url: '/moderator/unionList/' + id + '/reject',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });

    $('.buttonDelete').click(function (e) {
        e.preventDefault();
        if (confirm('Подтвердите')) {
            var id = $(this).data('id');
            var a = $(this).parent().parent().parent();
            ajaxJson({
                url: '/moderator/unionList/' + id + '/delete',
                success: function (ret) {
                    a.remove();
                    infoWindow('Успешно', function() {

                    });
                }
            });
        }
    });
});