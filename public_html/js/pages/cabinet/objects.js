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
});