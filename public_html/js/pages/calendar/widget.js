$(document).ready(function () {

    $(".buttonCopy1").zclip({
        path: pathZClip + '/ZeroClipboard.swf',
        copy: $('#textCode1').val(),
        beforeCopy: function () {
        },
        afterCopy: function () {
            infoWindow('Скопировано');
        }
    });
});