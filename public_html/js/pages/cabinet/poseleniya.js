$(document).ready(function () {

    $('.buttonDelete').click(function (e) {
        if (confirm('Подтвердите удаление')) {
            e.preventDefault();
            var id = $(this).data('id');
            ajaxJson({
                url: '/cabinet/poseleniya/' + id + '/delete',
                success: function (ret) {
                    infoWindow('Успешно', function() {
                        $('#objectItem-' + id).remove();
                    });
                }
            });
        }
    });
});