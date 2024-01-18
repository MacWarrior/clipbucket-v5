var max_try = 5;
var eventSource;
$(function () {

    connectSSE();
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
                    $('#progress-' + id_tool).show();
                    $('#progress-bar-' + id_tool).removeClass('progress-bar-success').attr('aria-valuenow', 0).width(0 + '%');
                    $('#span-' + id_tool).html(result['libelle_status']);
                    $('#pourcent-' + id_tool).html(0);
                    $('#done-' + id_tool).html(0);
                    $('#total-' + id_tool).html(0);
                    $('.page-content').prepend(result['msg']);
                    elem.parent().addClass('disabled');
                    $('.stop[data-id="' + id_tool + '"]').parent().removeClass('disabled');
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
                    eventSource.close();
                }
            });
        }
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
                elem.addClass('progress-bar-success');
                elem.width('100%');
                $('.launch[data-id='+id+']').parent().removeClass('disabled');
                $('.stop[data-id='+id+']').parent().addClass('disabled');+
                $('#span-' + id).html(lang.completed);
                $('#progress-bar-' + id).attr('aria-valuenow',100).width(100 + '%');
                $('#done-' + id).html($('#total-' + id).html());
                $('#pourcent-' + id).html(100);
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