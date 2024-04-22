var max_try = 5;
var eventSource;
var eventSourceLog;
var ids_stopped=[];
$(function () {
    if (can_sse == 'true') {
        connectSSE();
    }
    $('.launch').on('click', function () {
        var elem = $(this);
        if (!elem.parent().hasClass('disabled')) {
            var id_tool = $(this).data('id');
            $.ajax({
                url: "/actions/launch_tool.php",
                type: "POST",
                data: {id_tool: id_tool},
                dataType: 'json',
                success: function (result) {
                    $('#progress-bar-' + id_tool).removeClass('progress-bar-success').attr('aria-valuenow', 0).width(0 + '%');
                    $('#span-' + id_tool).html(result['libelle_status']);
                    $('#pourcent-' + id_tool).html(0);
                    $('#done-' + id_tool).html(0);
                    $('#total-' + id_tool).html(0);
                    $('.page-content').prepend(result['msg']);
                    elem.parent().addClass('disabled');
                    $('.stop[data-id="' + id_tool + '"]').parent().removeClass('disabled');
                    $('#progress-' + id_tool).show();
                }
            });
        }
    });
    $('.stop').on('click', function () {
        var elem = $(this);
        if (!$(this).parent().hasClass('disabled')) {
            var id_tool = elem.data('id');
            $.ajax({
                url: "/actions/stop_tool.php",
                type: "POST",
                data: {id_tool: id_tool},
                dataType: 'json',
                success: function (result) {
                    $('#span-' + id_tool).html(result['libelle_status']);
                    elem.parent().addClass('disabled');
                    $('.page-content').prepend(result['msg']);
                    ids_stopped.push(id_tool);
                }
            });
        }
    });
    $('.show_log').on('click', function () {
        var elem = $(this);
        if (!$(this).parent().hasClass('disabled')) {
            var id_tool = elem.data('id');
            $.ajax({
                url: "/actions/show_tool_log.php",
                type: "POST",
                data: {id_tool: id_tool},
                dataType: 'json',
                success: function (result) {
                    // Create new event, the server script is sse.php
                    connectSSELog(result['max_id_log'],result['id_tool']);
                    $('.page-content').prepend(result['msg']);
                    $('#logModal').find('.modal-body').html(result['template']);
                    $('#logModal').modal();
                }
            });
        }
    });

    $('#logModal').on('hidden.bs.modal', function () {
        eventSourceLog.close();
    });
});

function connectSSE () {
    var tries = 0;
    // Create new event, the server script is sse.php
    eventSource = new EventSource("/admin_area/sse/progress_tool.php");
    // Event when receiving a message from the server
    eventSource.addEventListener("message", function(e) {
        var data = JSON.parse(e.data);
        var ids_tool = [];
        data.forEach(function (tool) {
            $('#progress-bar-' + tool.id).attr('aria-valuenow',tool.pourcent).width(tool.pourcent + '%');
            $('#pourcent-' + tool.id).html(tool.pourcent);
            $('#done-' + tool.id).html(tool.elements_done);
            $('#total-' + tool.id).html(tool.elements_total);
            ids_tool.push(tool.id);
        });

        $('.progress-bar:visible').each(function (index, elem) {
            elem = $(elem);
            let id = elem.attr('data-id');
            if (!ids_tool.includes(id)) {
                if (ids_stopped.includes(parseInt(id))) {
                    elem.addClass('progress-bar-striped ').addClass('active');
                    const index = ids_stopped.indexOf(parseInt(id));
                    const x = ids_stopped.splice(index, 1);
                } else {
                    elem.addClass('progress-bar-success');
                    elem.width('100%');
                    $('.launch[data-id='+id+']').parent().removeClass('disabled');
                    $('.stop[data-id='+id+']').parent().addClass('disabled');+
                        $('#span-' + id).html(lang.completed);
                    $('#progress-bar-' + id).attr('aria-valuenow',100).width(100 + '%');
                    $('#done-' + id).html($('#total-' + id).html());
                    $('#pourcent-' + id).html(100);
                }
                setTimeout(function () {
                    $('#progress-' + id).hide();
                    $('#span-' + id).html(lang.ready);
                    $('#progress-bar-' + id).removeClass('progress-bar-success').attr('aria-valuenow', 0).width(0 + '%');
                    $('#pourcent-' + id).html(0);
                    $('#done-' + id).html(0);
                    $('#total-' + id).html(0);
                }, 10000);
            }
        });
    }, false);
    eventSource.addEventListener('open', function(e) {
        tries++
        if (tries > max_try) {
            eventSource.close();
        }
    }, false);

    eventSource.addEventListener('error', function(e) {
            eventSource.close();
    }, false);
}
function connectSSELog (max_id, id_tool) {
    var tries = 0;
    // Create new event, the server script is sse.php
    eventSourceLog = new EventSource("/admin_area/sse/logs_tool.php?max_id="+max_id+"&id_tool="+id_tool);
    // Event when receiving a message from the server
    eventSourceLog.addEventListener("message", function(e) {
        var data = JSON.parse(e.data);
        data.forEach(function (elem) {
            $('#tool_logs').append('<tr><td>'+elem.datetime+'</td><td>'+elem.message+'</td></tr>');
        });
    }, false);

    eventSourceLog.addEventListener('open', function(e) {
        tries++
        if (tries > max_try) {
            eventSourceLog.close();
        }
    }, false);

    eventSourceLog.addEventListener('error', function(e) {
            eventSourceLog.close();
    }, false);
}