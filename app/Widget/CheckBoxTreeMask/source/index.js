$(document).ready(function(){
    $('.checkBoxTreeMaskLi').on('mouseover', function() {
        $(this).find('a').removeClass('hide').show();
    });
    $('.checkBoxTreeMaskLi').on('mouseout', function() {
        $(this).find('a').hide();
    });
    var optionsConfirmation = {
        title: 'Подтвердите удаление',
        btnOkLabel: 'Да',
        btnCancelLabel: 'Нет',
        onConfirm: function() {
            var button = $(this);
            ajaxJson({
                url: '/checkBoxTreeMask/delete',
                data: {
                    id: button.data('id'),
                    tableName: button.data('table-name')
                },
                success: function (ret) {
                    // При удаление учитывать вложенные элементы
                    var next = button.parent()[0].nextSibling;
                    while(next) {
                        if (next.nodeName == '#text') {
                            if (next.nextSibling) {
                                next = next.nextSibling;
                            } else {
                                next = null;
                            }
                        } else {
                            break;
                        }
                    }
                    if (next) {
                        if (next.nodeName == 'UL') {
                            $(next).remove();
                        }
                    }

                    button.parent().remove();
                }
            });
        }
    };
    var functionButton = function() {
        var that = $(this);
        var thisId = that.data('id');
        that.popover({
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
                        url: '/checkBoxTreeMask/add',
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
                                )
                                .append(
                                    $('<label for="' + attrId + '" class="checkBoxTreeMaskLabel" style="margin-left: 4px;">' + text + '</label>')
                                )
                                .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButton hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-menu-down"></span></a>')
                                        .click(functionButton)
                                )
                                .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButton2 hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-menu-right"></span></a>')
                                        .click(functionButton2)
                                )
                                .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButtonRemove hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-remove"></span></a>')
                                        .confirmation(optionsConfirmation)
                                )
                                ;
                            var next = $(that).parent()[0].nextSibling;
                            while(next) {
                                if (next.nodeName == '#text') {
                                    if (next.nextSibling) {
                                        next = next.nextSibling;
                                    } else {
                                        next = null;
                                    }
                                } else {
                                    break;
                                }
                            }
                            if (next) {
                                if (next.nodeName == 'LI') {
                                    item.insertAfter($(that).parent());
                                } else if (next.nodeName == 'UL') {
                                    item.insertAfter($(next));
                                }
                            } else {
                                item.insertAfter($(that).parent());
                            }
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
        that.popover('show');
        $(".checkBoxTreeMaskClose").click(function() {
            $(".checkBoxTreeMaskButton[data-id='" + thisId + "']").popover('destroy');
        });
    };
    var functionButton2 = function() {
        var that = $(this);
        var thisId = that.data('id');
        that.popover({
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
                        url: '/checkBoxTreeMask/addInto',
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
                                )
                                    .append(
                                    $('<label for="' + attrId + '" class="checkBoxTreeMaskLabel" style="margin-left: 4px;">' + text + '</label>')
                                )
                                    .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButton hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-menu-down"></span></a>')
                                        .click(functionButton)
                                )
                                    .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButton2 hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-menu-right"></span></a>')
                                        .click(functionButton2)
                                )
                                    .append(
                                    $('<a href="javascript:void(0);" class="btn btn-default btn-xs checkBoxTreeMaskButtonRemove hide" data-id="'+id+'" data-table-name="'+that.data('table-name')+'" style="margin-left: 4px;"><span class="glyphicon glyphicon-remove"></span></a>')
                                        .confirmation(optionsConfirmation)
                                )
                                ;
                            var next = $(that).parent()[0].nextSibling;
                            while(next) {
                                if (next.nodeName == '#text') {
                                    if (next.nextSibling) {
                                        next = next.nextSibling;
                                    } else {
                                        next = null;
                                    }
                                } else {
                                    break;
                                }
                            }
                            var ul = $('<ul>');
                            if (next) {
                                if (next.nodeName == 'LI') {
                                    ul.append(item);
                                    ul.insertAfter(that.parent());
                                } else if (next.nodeName == 'UL') {
                                    item.insertBefore($(next.children[0]));
                                }
                            } else {
                                ul.append(item);
                                ul.insertAfter(that.parent());
                            }
                            that.popover('destroy');
                        }
                    });
                })
            ),
            placement: 'right',
            container: 'body',
            title: 'Добавить дочерний',
            template: '<div class="popover checkBoxTreeMaskPopover" role="tooltip"><button type="button" class="close checkBoxTreeMaskClose" data-id="'+thisId+'" aria-label="Close" style="margin: 5px 10px 0px 0px;"><span aria-hidden="true">&times;</span></button><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
        });
        that.popover('show');
        $(".checkBoxTreeMaskClose").click(function() {
            $(".checkBoxTreeMaskButton2[data-id='" + thisId + "']").popover('destroy');
        });
    };
    $('.checkBoxTreeMaskButton').click(functionButton);
    $('.checkBoxTreeMaskButton2').click(functionButton2);
    $('.checkBoxTreeMaskButtonRemove').confirmation(optionsConfirmation);
});
