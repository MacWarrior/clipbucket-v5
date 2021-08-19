$(document).ready(function(){
    var page = '/admin_area/index.php';

    $(".oneNote .delete").on({
        click: function(e){
            e.preventDefault();
            var noteId = $(this).parent().attr("id");
            delete_note(noteId);
            $(this).parents("li").remove();
        }
    });

    $("#add_new_note").on({
        click: function(e){
            e.preventDefault();
            var self = this;
            var note = $(this).parents(".widgetBox").find("textarea").val();
            if(!note){
                alert("Please enter something");
            } else {
                $(this).parents(".widgetBox").find("textarea").val("");
                $.post(page, {
                    mode : 'add_note',
                    note : note,
                },function(data) {
                    var li = document.createElement("li");
                    li.className = "col-md-4";
                    var a = document.createElement("a");
                    a.className = "delete";
                    a.href = "#";
                    a.innerHTML = "x";
                    var p = document.createElement("p");
                    p.id = data.id;
                    p.innerHTML = $("<textarea/>").text(note).html();
                    p.className = "oneNote";
                    $(p).append(a);
                    $(li).append(p);
                    $(a).on({
                        click: function(e){
                            e.preventDefault();
                            var noteId = $(this).parent().attr("id");
                            delete_note(noteId);
                            $(this).parents("li").remove();
                        }
                    });
                    $(self).parents(".widgetBox").find("ul").prepend(li);
                },'json');
            }
        }
    });

    $("#addTodo").on({
        click: function(e){
            e.preventDefault();
            var self = this;
            var newVal = $(this).parents(".addTodo").find("input").val();
            if(newVal.length)
            {
                $(this).parents(".addTodo").find("input").val("");
                $.ajax({
                    url: page,
                    type: "post",
                    data: {
                        val: newVal,
                        mode: "add_todo"
                    },
                    success: function (data) {
                        data = $.parseJSON(data);
                        var li = document.createElement("li");
                        li.className = "col-md-12";
                        var p = document.createElement("p");
                        p.className = "oneTodo paddingLeftSmall col-md-10";
                        p.id = data.id;
                        p.innerHTML = data.todo;
                        var a = document.createElement("a");
                        a.href = "#";
                        a.className = "col-md-2 btn btn-danger btn-xs delete";
                        a.innerHTML = lang_delete;
                        $(a).on("click", function(e){
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
                        var div = document.createElement("div");
                        div.className = "col-md-12";

                        $(li).append(div).find("div").append(p).append(a);
                        $(self).parents(".widgetBox").find("ul").prepend(li);
                    }
                });
            } else {
                alert("Please enter a valid value");
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

    $(".saveTodo").click(function(e){
        var self = this;
        var newVal = $(this).parent().parent().find("input[name='todo']").val();
        if(newVal.length){
            $.ajax({
                url: "/admin_area/index.php",
                type: "post",
                data: {
                    val: newVal,
                    mode: "add_todo"
                },
                success: function (data) {
                    data = $.parseJSON(data);
                    var p = document.createElement("p");
                    p.className = "xedit editable editable-click";
                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "todoid";
                    input.value = data.id;
                    var b = document.createElement("b");
                    b.innerHTML = data.todo;
                    p.appendChild(input);
                    p.appendChild(b);
                    console.log(p);
                    $(self).parents("form").after(p);
                }
            });
        } else {
            alert("Please enter a valid value");
        }
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