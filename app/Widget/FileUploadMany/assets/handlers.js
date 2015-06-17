/**
 * Мультизагрузчик
 * Инициализатор
 * Зависит от CS (app/assets/CsAppAsset/source/js/cs.js)
 *
 * @author Dmitrii Mukhortov <dram1008@yandex.ru>
 */
var FileUploadMany = {


    /**
     * Добавляет к строке элемент-объект ['fileIndex','fileName']
     * @param string
     * @param item
     * @returns {*}
     */
    filesAdd: function (string, item) {
        var files = string;
        var filesArray = [];
        if (files != '') {
            filesArray = CS.jsonDecode(files);
        }
        filesArray.push(item);

        return CS.jsonEncode(filesArray);
    },


    /**
     * Выполняет функцию filesAdd для объекта указываемого через selector
     * @param selector
     * @param item
     */
    filesAddSelector: function (selector, item) {
        var string = $(selector).val();
        var stringNew = FileUploadMany.filesAdd(string, item);
        $(selector).val(stringNew);
    },

    /**
     * Удаляет из строки элемент-объект ['fileIndex','fileName']
     * @param string
     * @param item
     * @returns {*}
     */
    filesDelete: function (string, item) {
        var files = string;
        var filesArray = CS.jsonDecode(files);
        var filesArrayNew = [];
        for (var i = 0; i < filesArray.length; i++) {
            if (item[0] != filesArray[i][0]) {
                filesArrayNew.push(filesArray[i]);
            }
        }

        return CS.jsonEncode(filesArrayNew);
    },

    /**
     * Выполняет функцию filesDelete для объекта указываемого через selector
     * @param selector
     * @param item
     */
    filesDeleteSelector: function (selector, item) {
        var string = $(selector).val();
        var stringNew = FileUploadMany.filesDelete(string, item);
        $(selector).val(stringNew);
    },

    /**
     * Инициализирует виджет
     *
     * @param selector
     * @param options
     *  - files = инициализируемые данные
     *            like [
     *                     [
     *                           "1426236797_VCcbwQjgF3.jpg", // путь к файлу относительно корня сайта
     *                           "IMG_20141105_113242.jpg" // название файла
     *                     ], ...
     *                 ]
     * - maxFilesCounter - int
     */
    init: function (selector, options) {
        options.onSuccess = function (files, data, xhr) {
            var status;
            var selectorThis = selector + '-files';
            for (i in data) {
                if (i == 'error') status = 'error';
                if (i == 'success') status = 'success';
            }
            if (status == 'success') {
                data = data.success;
                FileUploadMany.filesAddSelector(selectorThis, data[0]);

                return;
            }
            if (status == 'error') {

            }
        };
        options.deleteCallback = function (data, pd) {
            var selectorThis = selector + '-files';
            data = data.success;

            var item = data[0];
			var fileId = item[2] ? item[2] : 0;
            FileUploadMany.filesDeleteSelector(selectorThis, item);
            pd.statusbar.hide();

            /*$.ajax({
                url: '/upload/delete',
                type: 'post',
                data: {
                    fileName: item[0],
					fileId: fileId
                },
                success: function (ret) {
                }
            });*/
        };
		
		var opts = $.extend({loadedFiles: JSON.parse($(selector + '-files').val())}, options);
		
        return jQuery(selector).uploadFile(opts);
    }
};