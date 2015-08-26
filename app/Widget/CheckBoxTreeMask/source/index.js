$(document).ready(function(){
    $('.checkBoxTreeMaskLi').on('mouseover', function() {
        $(this).find('a').removeClass('hide').show();
    });
    $('.checkBoxTreeMaskLi').on('mouseout', function() {
        $(this).find('a').hide();
    });
    var functionButton = function() {
        var that = $(this);
        var thisId = that.data('id');
        $(this).popover({
            html: true,
            content: $('<div>').append(
                $('<div>' , {
                    class: 'form-group'
                }).append(
                    $('<input>', {
                        type: 'text',
                        class: 'form-control checkBoxTreeMaskText',
                        'data-id': thisId
                    })
                )
            ).append(
                $('<button>', {
                    class: 'btn btn-default checkBoxTreeMaskButtonAdd',
                    style: 'width: 100%',
                    'data-id': thisId
                }).html('Добавить').click(function() {
                    var button = $(this);
                    var text = button.parent().find('input').val();
                    ajaxJson({
                        url: '/checkBoxTreeMask/add/ajax',
                        data: {
                            text: text,
                            id: button.data('id'),
                            tableName: that.data('table-name')
                        },
                        success: function (ret) {
                            var id = ret.id;
                            var idPrefix = that.parent().find('input').attr('id');
                            var pos = idPrefix.lastIndexOf('-');
                            idPrefix = idPrefix.substring(0, pos);
                            var attrName = that.parent().find('input').attr('name');
                            var attrId = idPrefix + '-' + id;
                            var item = $('<li>', {
                                class: 'checkBoxTreeMaskLi'
                            })
                                .on('mouseover', function() {
                                    $(this).find('a').removeClass('hide').show();
                                })
                                .on('mouseout', function() {
                                    $(this).find('a').hide();
                                })
                                .append(
                                    $('<input type="checkbox" id="' + attrId + '" name="' + attrName + '" value="' + id + '">')
                                ).append(
                                    $('<label for="' + attrId + '" class="checkBoxTreeMaskLabel" style="margin-left: 4px;">' + text + '</label>')
                                ).append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButton hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;">+</a>')
                                        .click(functionButton)

                                );
                            item.insertAfter($(that).parent());
                            that.popover('destroy');
                        }
                    });
                })
            ),
            placement: 'right',
            container: 'body',
            title: 'Добавить после',
            template: '<div class="popover checkBoxTreeMaskPopover" role="tooltip"><button type="button" class="close checkBoxTreeMaskClose" data-id="'+thisId+'" aria-label="Close" style="margin: 5px 10px 0px 0px;"><span aria-hidden="true">&times;</span></button><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
        });
        $(this).popover('show');
        $(".checkBoxTreeMaskClose").click(function() {
            $(".checkBoxTreeMaskButton[data-id='"+thisId+"']").popover('destroy');
        });
    };
    $('.checkBoxTreeMaskButton').click(functionButton)
});
