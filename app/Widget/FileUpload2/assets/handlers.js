var FileUpload2 = {
    // - selector - string - селектор JQuery элемента
    deleteCallback: function (selector) {
        console.log('deleteCallback');
    },
    onChange: function (selector) {
        $(selector).on('change', function (e) {
            console.log(e);
            $(selector + '-img_name').html(e.target.value);
            $(selector + '-value').val(e.target.value);
        });
    },
    init: function(selector){
        $(selector).on('change', function (e) {
            console.log(e);
            $(selector + '-value').val(e.target.value);
            $(selector + '-img_name').html(e.target.value);
            $(selector + '-img').remove();
        });
        $(selector + '-delete').click(function(){
            $(selector + '-img').remove();
            $(selector + '-img_name').html('');
            $(selector + '-value').val('');
            $.ajax({
                url: '/upload2',
                success: function(ret) {

                }
            });
        });
    }
};


