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
            },'text');
    }

    $('.oneNote .delete').on({
        click: function(e){
            e.preventDefault();
            var noteId = $(this).parent().attr('id');
            delete_note(noteId);
            $(this).parents('li').remove();
        }
    });

    $('#add_new_note').on({
        click: function(e){
            e.preventDefault();
            var note = $(this).parents('.addNote').find('textarea').val();
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
            var self = this;
            var newVal = $(this).parents('.addTodo').find('input').val();
            if(newVal.length)
            {
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
        var self = this;
        var id = $(this).prev().attr("id");
        $.ajax({
            url: page,
            type: "post",
            data: {
                id: id,
                mode: "delete_todo"
            },
            success: function (data) {
                $(self).parents("li").remove();
            }
        });
    });

    $("#todolist").on("click", ".editable-clear-x", function(e){
        e.preventDefault();
        var self = this;
        var id = $(this).parents(".editable-container").prev().attr("id");
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
                $(self).parents("p").remove();
                $(self).parents(".editable-container").remove();
            }
        });
        e.stopPropagation();
    });
});