$(document).ready(function() {

    var page = 1;
    var isStartLoad = false;
    var isFinished = false;
    $(window).on('scroll', function() {

        var sizeBottom = $('#layoutMenuFooter').height() + $('#layoutMenuFooter').find('.container').height() + 420;
        if ($(window).scrollTop() > $(document).height() - sizeBottom) {

            console.log(12);
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
                        success: function(ret) {
                            if (ret == '') isFinished = true;
                            $('#channelingList').append(ret);
                            isStartLoad = false;
                        }
                    });
                }
            }
        }

    });
});
