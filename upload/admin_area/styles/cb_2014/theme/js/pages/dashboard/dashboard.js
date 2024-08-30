var max_try = 5;
var eventSource;
$(document).ready(function(){
    var page = '/admin_area/index.php';

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
            url: "/admin_area/index.php",
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
        connectSSE();
    }

    $('.update_core').on('click', function () {
        update('core')
    });
    $('.update_db').on('click', function () {
        update('db')
    });

    $('.launch_wip').on('click', function () {
        showSpinner();
        $.ajax({
            url: "/actions/admin_launch_wip.php",
            type: "post",
            dataType: "json",
            success: function (data) {
                hideSpinner();
                if (data.success == false) {
                    $(".page-content").prepend(data.msg)
                }
            }
        });
    })
});

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

function update(type){
    $.ajax({
        url: "/actions/admin_launch_update.php",
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

            connectSSE();

        }
    });
}

function connectSSE() {
    var tries = 0;
    // Create new event, the server script is sse.php
    eventSource = new EventSource("/admin_area/sse/update_info.php");
    // Event when receiving a message from the server
    eventSource.addEventListener("message", function (e) {
        var data = JSON.parse(e.data);
        if (data.is_updating === 'false') {
            eventSource.close();
        }
        $('#update_div').html(data.html);

    });
    eventSource.addEventListener('open', function (e) {
        tries++
        if (tries > max_try) {
            eventSource.close();
        }
    }, false);

    eventSource.addEventListener('error', function (e) {
        eventSource.close();
    }, false);
}