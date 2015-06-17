
$(document).ready(function(){
    var openedPopup = 0;
    /**
     *
     * @param d день от 1
     * @param m месяц от 1
     * @param y год четырехзначный
     * @returns {string}
     */
    function dateFormat (d,m,y) {
        var mArr = [
            'Янв',
            'Фев',
            'Мар',
            'Апр',
            'Май',
            'Июн',
            'Июл',
            'Авг',
            'Сен',
            'Окт',
            'Ноя',
            'Дек'
        ];

        var mStr = mArr[m - 1];
        return d + ' ' + mStr + ' ' + y + ' г.';
    }

    $('#buttonVkontakte').click(function(){
        ajaxJson({
            url: '/calendar/friends/vkontakte',
            beforeSend: function() {
                $('#friends').html($('<img>', {
                    src: LayoutAssetUrl + '/images/ajax-loader.gif'
                }));
            },

            /**
             *
             * @param ret
             * {
             *  'friends' : [],
             * }
             */
            success: function(ret) {
                var table = $('<table>').addClass('table table-striped');
                $.each(ret.friends,function(i,v) {
                    var tr = $('<tr>');
                    tr.append(
                        $('<td>').html(
                            $('<a>', {
                                'href': 'https://vk.com/id' + v.id,
                                'target': '_blank'
                            }).append(
                                $('<img>', {
                                    'src': v.avatar,
                                    'width': 64,
                                    'height': 64,
                                    'class':"img-thumbnail"
                                })
                            )
                        ));
                    var maya = Maya.calc(v.birthDate[0],v.birthDate[1],v.birthDate[2]);
                    tr.append(
                        $('<td>').html(
                            $('<img>', {
                                'src': pathMaya  + '/images/stamp3/' + maya.stamp + '.gif',
                                'width': 30,
                                'height': 30,
                                'class': 'js-time',
                                'title': Maya.stampList[maya.stamp - 1][0]
                            })
                        ));
                    tr.append(
                        $('<td>').html(
                            $('<img>', {
                                'src': pathMaya  + '/images/ton/' + maya.ton + '.gif',
                                'width': 30,
                                'height': 30,
                                'class': 'js-time',
                                'title': Maya.tonList[maya.ton - 1][0]
                            })
                        ));
                    tr.append(
                        $('<td>').html(
                            dateFormat(v.birthDate[0],v.birthDate[1],v.birthDate[2])
                        ));
                    tr.append(
                        $('<td>').html(
                            v.name
                        ));
                    tr.append(
                        $('<td>').html(
                            $('<button>', {
                                'class': 'btn btn-default buttonCalc',
                                'data-maya': CS.jsonEncode(maya)
                            }).html('Добавить').on('click', function() {
                                var b = $(this);
                                if (b.hasClass('active')) {
                                    b.removeClass('active').html('Добавить')
                                } else {
                                    b.addClass('active').html('Исключить')
                                }
                                if (typeof openedPopup != 'number') {
                                    openedPopup.popover('destroy');
                                    openedPopup = 0;
                                    console.log(typeof openedPopup);
                                }
                                var myDate = $('#meBirthDate').html();
                                var arr = myDate.split('-');
                                var y = parseInt(arr[0]);
                                var m = parseInt(arr[1]);
                                var d = parseInt(arr[2]);
                                var myMaya = Maya.calc(d,m,y);

                                var all = [];
                                $('.buttonCalc').each(function(i,v) {
                                    var button = $(v);
                                    if (button.hasClass('active')) {
                                        var maya = button.data('maya');
                                        all.push(maya.kin);
                                    }
                                });
                                if (all.length > 0){
                                    all.push(myMaya.kin);
                                    var mayaAll = Maya.calcUnion(all);

                                    b.popover({
                                        //content: all.kin,
                                        content: $('<div>')
                                            .append(
                                            $('<img>', {
                                                src: MayaAssetUrl + '/images/ton/' + mayaAll.ton + '.gif',
                                                width: 30,
                                                height: 30
                                            })
                                        )
                                            .append(
                                            $('<img>', {
                                                src: MayaAssetUrl + '/images/stamp3/' + mayaAll.stamp + '.gif',
                                                width: 30,
                                                height: 30,
                                                style: 'padding-left: 15px'
                                            })
                                        )
                                        ,
                                        html: true,
                                        placement: 'right',
                                        title: 'Общая сумма',
                                        template: '<div class="popover" role="tooltip" style="width: 150px;"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content" style="padding-bottom:30px;"></div></div>'
                                    });
                                    b.popover('show');
                                    openedPopup = b;
                                }
                            })
                        ));

                    table.append(tr);
                });
                table.find('.js-time').tooltip();
                $('#friends').html(table);
            }
        });
    });
});