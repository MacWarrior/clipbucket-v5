var max_try = 5;
var eventSource;
$(document).ready(function(){
    var page = admin_url + 'index.php';

    function delete_note(id)
    {
        $.post(page, {
                mode : 'delete_note',
                id : id
            },
            function(data) {
                $('#note-'+id).slideUp();
            },'text'
        );
    }

    $('.oneNote .delete').on({
        click: function(e){
            e.preventDefault();
            let noteId = $(this).parent().attr('id');
            delete_note(noteId);
            $(this).parents('li').remove();
        }
    });


    $('#add_new_note').on({
        click: function(e){
            e.preventDefault();
            let note = $(this).parents('.addNote').find('textarea').val();
            if(!note){
                alert('Please enter something');
            } else {
                $(this).parents(".addNote").find("textarea").val('');
                $.post(page, {
                    mode : 'add_note',
                    note : note,
                },function(data) {
                    var li = document.createElement('li');
                    li.className = 'col-md-4';
                    var a = document.createElement('a');
                    a.className = 'delete';
                    a.href = '#';
                    a.innerHTML = 'x';
                    var p = document.createElement('p');
                    p.id = data.id;
                    p.innerHTML = $("<textarea/>").text(note).html();
                    p.className = 'oneNote';
                    $(p).append(a);
                    $(li).append(p);
                    $(a).on({
                        click: function(e){
                            e.preventDefault();
                            var noteId = $(this).parent().attr('id');
                            delete_note(noteId);
                            $(this).parents('li').remove();
                        }
                    });
                    $('.notesList').prepend(li);
                },'json');
            }
        }
    });

    $("#addTodo").on({
        click: function(e){
            e.preventDefault();
            let newVal = $(this).parents('.addTodo').find('input').val();
            if(newVal.length) {
                $(this).parents('.addTodo').find('input').val("");
                $.ajax({
                    url: page,
                    type: 'post',
                    data: {
                        val: newVal,
                        mode: 'add_todo'
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        var li = document.createElement('li');
                        li.className = 'col-md-12 oneTodo';
                        var p = document.createElement('span');
                        p.className = 'paddingLeftSmall col-md-10';
                        p.id = data.id;
                        p.innerHTML = data.todo;
                        var a = document.createElement('a');
                        a.href = '#';
                        a.className = 'btn btn-danger btn-xs delete col-md-2';
                        a.innerHTML = lang_delete;
                        $(a).on("click", function(e){
                            e.preventDefault();
                            var self = this;
                            var id = $(this).prev().attr('id');
                            $.ajax({
                                url: page,
                                type: 'post',
                                data: {
                                    id: id,
                                    mode: 'delete_todo'
                                },
                                success: function (data) {
                                    $(self).parents('li').remove();
                                }
                            });
                        });

                        $(li).append(p).append(a);
                        $('.todosList').prepend(li);
                    }
                });
            } else {
                alert('Please enter a valid value');
            }
        }
    });

    $("#todolist .delete").on("click", function(e){
        e.preventDefault();

        $.ajax({
            url: page,
            type: "post",
            data: {
                id: $(this).prev().attr("id"),
                mode: "delete_todo"
            },
            success: function (data) {
                this.parents("li").remove();
            }
        });
    });

    $("#todolist").on("click", ".editable-clear-x", function(e){
        e.preventDefault();
        let id = $(this).parents(".editable-container").prev().attr("id");
        id = id.match(/([0-9]+)$/g);
        id = id.pop();
        $.ajax({
            url: page,
            type: "post",
            data: {
                id: id,
                mode: "delete_todo"
            },
            success: function (data) {
                $(this).parents("p").remove();
                $(this).parents(".editable-container").remove();
            }
        });
        e.stopPropagation();
    });

    if (can_sse === 'true' && is_update_processing === 'true') {
        // connectSSE();
    }
    if (is_update_processing === 'true') {
        refreshUpdateProgression();
    }
    updateListeners();

    if( visual_editor_comments_enabled ){
        Array.from(document.querySelectorAll('#rcomments .itemdiv .text')).forEach((comment,index) => {
            new toastui.Editor.factory({
                el: comment,
                viewer: true,
                usageStatistics: false,
                initialValue: comment.innerHTML
            });
        });
    }

    AmCharts.makeChart("piechart", {
        "type": "pie",
        "adjustPrecision": true,
        "angle": 12,
        "balloonText": "[[title]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
        "depth3D": 15,
        "maxLabelWidth": 150,
        "titleField": "category",
        "valueField": "column-1",
        "processTimeout": 5,
        "theme": "light",
        "allLabels": [],
        "balloon": {},
        "legend": {
            "enabled": true,
            "align": "left",
            "markerType": "circle"
        },
        "titles": [
            {
                "bold": false,
                "id": "Title-1",
                "size": 15,
                "text": lang['overall_statistics']
            }
        ],
        "dataProvider": [
            {
                "category": lang['users'],
                "column-1": piechart_users
            },
            {
                "category": lang['photos'],
                "column-1": piechart_photos
            },
            {
                "category": lang['videos'],
                "column-1": piechart_videos
            },
            {
                "category": lang['collections'],
                "column-1": piechart_collections
            },

        ]
    });

    AmCharts.makeChart("donutchart", {
        "type": "pie",
        "angle": 12,
        "balloonText": "[[title]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
        "depth3D": 15,
        "innerRadius": "30%",
        "titleField": "category",
        "valueField": "column-1",
        "processTimeout": 5,
        "theme": "light",
        "allLabels": [],
        "balloon": {},
        "legend": {
            "enabled": true,
            "align": "center",
            "markerType": "circle"
        },
        "titles": [
            {
                "bold": false,
                "id": "Title-1",
                "size": 15,
                "text": lang['flagged_obj']
            }
        ],
        "dataProvider": [

            {
                "category": lang['photos'],
                "column-1": donutchart_photos
            },
            {
                "category": lang['videos'],
                "column-1": donutchart_videos
            },
            {
                "category": lang['users'],
                "column-1": donutchart_users
            },
            {
                "category": lang['collections'],
                "column-1": donutchart_collections
            }
        ]
    });

    AmCharts.makeChart("ubarchart", {
        "type": "serial",
        "pathToImages": "https://www.amcharts.com/lib/3/images/",
        "categoryField": "category",
        "startDuration": 1,
        "mouseWheelZoomEnabled": true,
        "startEffect": "easeOutSine",
        "autoDisplay": true,
        "theme": "light",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "trendLines": [],
        "graphs": [
            {
                "colorField": "color",
                "fillAlphas": 1,
                "id": "AmGraph-1",
                "lineColorField": "color",
                "title": "graph 1",
                "type": "column",
                "valueField": "column-1"
            }
        ],
        "guides": [],
        "valueAxes": [
            {
                "id": "ValueAxis-1",
                "title": lang['users']
            }
        ],
        "allLabels": [],
        "balloon": {},
        "titles": [
            {
                "bold": false,
                "id": "Title-1",
                "size": 15,
                "text": lang['user_statistics']
            }
        ],
        "dataProvider": [
            {
                "category": lang["total"],
                "column-1": ubarchart_users
            },
            {
                "category": lang["active"],
                "column-1": ubarchart_users_active
            },
            {
                "category": lang["inactive"],
                "column-1": ubarchart_users_inactive
            }
        ]
    }); 
    AmCharts.makeChart("vbarchart", {
        "type": "serial",
        "pathToImages": "https://www.amcharts.com/lib/3/images/",
        "categoryField": "category",
        "startDuration": 1,
        "mouseWheelZoomEnabled": true,
        "startEffect": "easeOutSine",
        "autoDisplay": true,
        "theme": "light",
        "categoryAxis": {
            "gridPosition": "start"
        },
        "trendLines": [],
        "graphs": [
            {
                "colorField": "color",
                "fillAlphas": 1,
                "id": "AmGraph-1",
                "lineColorField": "color",
                "title": "graph 1",
                "type": "column",
                "valueField": "column-1"
            }
        ],
        "guides": [],
        "valueAxes": [
            {
                "id": "ValueAxis-1",
                "title": lang["videos"]
            }
        ],
        "allLabels": [],
        "balloon": {},
        "titles": [
            {
                "bold": false,
                "id": "Title-1",
                "size": 15,
                "text": lang['video_statistics']
            }
        ],
        "dataProvider": [
            {
                "category": lang['total'],
                "column-1": vbarchart_total
            },
            {
                "category": lang['active'],
                "column-1": vbarchart_active
            },
            {
                "category": lang['inactive'],
                "column-1": vbarchart_deactive
            },
            {
                "category": lang['reported'],
                "column-1": vbarchart_reported
            }
        ]
    });

    $('#update_dp_options').on('click', function () {
        var val = $(this).parent().find('input').val();
       $.ajax({
           url: 'actions/display_option_update.php',
           type: 'post',
           dataType: 'json',
           data: {admin_pages: val},
           success: function (data) {
               $(".page-content").prepend(data.msg);
           }
       })
    });
});

function updateListeners () {
    $('.update_core').on('click', function () {
        update('core')
    });
    $('.update_db').on('click', function () {
        update('db')
    });

    $('.launch_wip').on('click', async function () {
        var interrupt = await check_before_launch_update();
        if (interrupt) {
            showSpinner();
            $.ajax({
                url: 'actions/update_launch_wip.php',
                type: "post",
                dataType: "json",
                success: function (data) {
                    hideSpinner();
                    if (data.success == false) {
                        $(".page-content").prepend(data.msg)
                    }
                    var wip_div = $('.launch_wip').parents('.alert');
                    var parent = wip_div.parent();
                    wip_div.remove();
                    parent.append(data.template)
                    updateListeners();
                }
            });
        }
    });

    $('.mark_as_failed').off('click').on('click', function () {
        var id = $(this).data('id');
        if (confirm(lang.confirm_mark_as_failed)) {
            $.ajax({
                url: baseurl + "actions/force_tool_to_error.php",
                type: "POST",
                data: {id_tool: id},
                dataType: 'json',
                success: function (result) {
                    showSpinner();
                }
            });
        } else {
            return false;
        }
    })
}

let showMsg = function(msg, type, autoDismiss){

    let randomid = 'ajax_msg_'+(Math.random() + 1).toString(36).substring(7);

    /** show error msg */
    $("#update_div").append('<div role="alert" id="'+randomid+'" class="alert alert-'+type+' alert-dismissible">' +
        '    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' +
        '    <div class="msg">'+msg+'</div>' + '</div>');

    if(autoDismiss === true) {
        setTimeout(function(){
            $("#"+randomid).addClass("hidden");
        }, 5000);
    }

}

async function update(type){
    $('.launch_wip').off('click').prop('disabled', 'disabled');
    $('.update_db').off('click').prop('disabled', 'disabled');
    $('.update_core').off('click').prop('disabled', 'disabled');

    //check update db
    //check conversion
    var is_checked = await check_before_launch_update();
    if (!is_checked) {
        return;
    }
    $.ajax({
        url: "actions/update_launch.php",
        type: "post",
        data: {
            type: type
        },
        success: function (data) {
            let response;
            try {
                response = JSON.parse(data);
            }catch (e) {
                response.success = false
            }

            if(response.success !== true) {
                let error_msg = lang.technical_error;
                if(response.error_msg !== undefined && response.error_msg != null && response.error_msg != '') {
                    error_msg = response.error_msg;
                }
                showMsg(error_msg, 'danger');
                return ;
            }

            // connectSSE();
            refreshUpdateProgression();
        }
    });
}

async function check_before_launch_update() {
    var core_checked = false;
    var db_checked = false;
    var conversion_checked = false;
    var interrupt = false;
    const data = await $.ajax({
        url: "actions/update_check_before_launch.php",
        type: "post",
        dataType: "json",
        processData: false,
        data: {
            core_checked: core_checked, db_checked: db_checked, conversion_checked: conversion_checked
        }
    });
    if (!data.core_checked) {
        //put tool on error
        if (typeof data.confirm_message_core === 'string' && data.confirm_message_core !== '') {
            if (confirm(data.confirm_message_core)) {
                await $.ajax({
                    url: "actions/tool_force_to_error.php",
                    type: "POST",
                    data: {id_tool: data.id_tool},
                    dataType: 'json',
                    success: function (result) {
                        core_checked = true
                    }
                });
            } else {
                return false;
            }
        }
    }
    if (!data.db_checked) {
        //put tool on error
        if (typeof data.confirm_message_db === 'string' && data.confirm_message_db !== '') {
            if (confirm(data.confirm_message_db)) {
                await $.ajax({
                    url: "actions/tool_force_to_error.php",
                    type: "POST",
                    data: {id_tool: data.id_tool},
                    dataType: 'json',
                    success: function (result) {
                        console.log('ajax success')
                        db_checked = true;
                    }
                });
            } else {
                return false;
            }
        }
    }
    if (!data.conversion_checked && !interrupt) {
        if (typeof data.confirm_message_conv === 'string' && data.confirm_message_conv !== '') {
            if (confirm(data.confirm_message_conv)) {
                conversion_checked = true;
            } else {
                return false;
            }
        }
    }
    return true;
}

function refreshUpdateProgression() {
    var interval = setInterval(function () {
        $.ajax({
            url: "actions/update_info.php",
            type: "post",
            dataType: "json",
            success: function (data) {
                $('#update_div').html(data.html);
                updateListeners();
                hideSpinner();
                if (data.msg_template) {
                    $(".page-content").prepend(data.msg_template)
                }
                if (data.is_updating === 'false') {
                    clearInterval(interval);
                    checkStatus();
                } else {
                    var tool = data.update_info;
                    $('.launch_wip').off('click');

                    if (tool && tool.elements_done > 0) {
                        $('#progress_div').show();
                    }
                    $('#progress-bar').attr('aria-valuenow', tool.pourcent).width(tool.pourcent + '%');
                    $('#pourcent').html(tool.pourcent);
                    $('#done').html(tool.elements_done);
                    $('#total').html(tool.elements_total);
                }
            }
        });
    }, 5000);
}

function checkStatus() {
    $.ajax({
        url: "actions/update_check.php",
        type: "post",
        dataType: "json",
        success: function (data) {
            $('#changelog_display').html(data.changeLog);
            $('#status_html').html(data.html);

            if (data.msg) {
                $(".page-content").prepend(data.msg)
            }

            $('.footer').find('em>a').html('V'+data.version +' - ' + data.revision);
        }
    });
}