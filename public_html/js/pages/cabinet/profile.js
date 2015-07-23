$(document).ready(function () {

    $('.buttonUnLink').click(function (e) {
        if (confirm('Подтвердите отсоединение')) {
            var objectButton = $(this);
            var name = objectButton.data('name');
            ajaxJson({
                url: '/cabinet/profile/unLinkSocialNetWork',
                data: {
                    name: name
                },
                success: function (ret) {
                    var td = objectButton.parent();
                    td.find('*').each(function() {
                        $(this).remove();
                    });
                    td.append($('<a>', {
                        href: '/auth?authclient=' + name,
                        target: '_blank'
                    }).html('Присоединить профиль'));
                }
            });
        }
    });
});