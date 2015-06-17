
$(document).ready(function () {

    var functionSend = function(){
        if ($('#form-content').val() == '') {
            infoWindow('Заполните пожалуйста комментарий');
            return;
        }
        ajaxJson({
            url: '/comment/send',
            data: $('#comment-form').serializeArray(),
            /**
             * @param ret
             * {
             *      text: str,
             *      user: {
             *              id: int,
             *              name: str,
             *              avatar: str,
             *            }
             * }
             */
            success: function(ret) {
                $('.commentList').append($('#commentTemplate').render({
                    'user__id': ret.user.id,
                    'user__name': ret.user.name,
                    'user__avatar': ret.user.avatar,
                    'content': ret.text
                }));
                $('#form-content').val('');
            }
        });
    };

    $('#form-content').on('keypress', function (e) {
        //Производит нажатие по кнопке отправить сообщение. Отлавливает ctrl+enter
        e = e || window.event;

        if (e.keyCode == 10 || e.keyCode == 13 && (e.ctrlKey || e.metaKey && browser.mac)) {
            functionSend();
        }
    });

    $('#commentButton').click(functionSend);

    $('#authCommentButton').click(function () {
        console.log(123);
        $('#loginModal').modal('show');
    });

});