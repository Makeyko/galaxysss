$(document).ready(function () {

    $('.buttonDelete').click(function (e) {
        if (confirm('Подтвердите удаление')) {
            e.preventDefault();
            var id = $(this).data('id');
            ajaxJson({
                url: '/admin/articleList/' + id + '/delete',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        $('#newsItem-' + id).remove();
                    });
                }
            });
        }
    });
});