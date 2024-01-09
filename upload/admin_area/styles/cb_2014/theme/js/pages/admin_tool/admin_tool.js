var max_try = 5;
$(function () {
    var tries = 0;
    // Create new event, the server script is sse.php
    var eventSource = new EventSource("/actions/progress_tool.php");
    // Event when receiving a message from the server
    eventSource.addEventListener("message", function(e) {
        console.log(e.data);
    }, false);
    eventSource.addEventListener('open', function(e) {
        console.log('opened');
        if (tries > max_try) {
            eventSource.close();
        }
        tries++
    }, false);

    eventSource.addEventListener('error', function(e) {
        if (e.readyState == EventSource.CLOSED) {
// Connection was closed.
        console.log('closed');
        }
    }, false);
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
                    $('#progress-bar-' + id_tool).attr('aria-valuenow', 0);
                    $('#span-' + id_tool).html(result['libelle_status']);
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