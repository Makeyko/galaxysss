$(document).ready(function() {

    var page = 1;
    var isStartLoad = false;
    var isFinished = false;
    $(window).on('scroll', function() {

        var sizeBottom = $('#layoutMenuFooter').height() + $('#layoutMenuFooter').find('.container').height() + 420;
        if ($(window).scrollTop() > $(document).height() - sizeBottom) {

            if (isFinished == false) {
                if (isStartLoad === false) {
                    isStartLoad = true;
                    page++;
                    $('#chennelingPages').remove();
                    ajaxJson({
                        url: '/chenneling/ajax',
                        data: {
                            page: page
                        },
                        beforeSend: function() {
                            $('#channelingList').append(
                                $('<div>', {
                                    id: 'channelingListLoading',
                                    class: 'col-lg-12'
                                }).append(
                                    $('<img>', {src: pathLayoutMenu + '/images/ajax-loader.gif'})
                                )
                            );
                        },
                        success: function(ret) {
                            if (ret == '') isFinished = true;
                            $('#channelingListLoading').remove();
                            $('#channelingList').append(ret);
                            isStartLoad = false;
                        }
                    });
                }
            }
        }

    });
});
