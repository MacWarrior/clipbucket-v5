var eventSource;
var max_try = 2;

function regenerateThumbs(videoid) {
    $.ajax({
        url: "/actions/regenerate_thumbs.php",
        type: "post",
        data: {videoid: videoid},
        dataType: 'json',
        beforeSend: function () {
            showSpinner();
            $('#auto_thumbs .tools-bottom').hide();
        },
        success: function (response) {
            $('#thumb_list').html(response['template']);
            $('.page-content').prepend(response['msg']);
            connectSSE();
            hideSpinner();
        }
    });
}

function delete_thumb(videoid, num, type) {
    $.ajax({
        url: "/actions/delete_thumbs.php",
        type: "post",
        dataType: 'json',
        data: {videoid: videoid, num: num, type: type}
    }).done(function (result) {
        $('#thumb_list').html(result['template']);
    }).always(function (result) {
        $('.page-content').prepend(result['msg']);
    });
}

function connectSSE() {
    if (can_sse !== 'true') {
        return;
    }

    let tries = 0;
    // Create new event, the server script is sse.php
    eventSource = new EventSource("/admin_area/sse/progress_generate_thumb.php?id_video=" + video_id);
    // Event when receiving a message from the server
    eventSource.addEventListener("message", function (e) {
        var data = JSON.parse(e.data);
        $('#thumb_list').html(data.html);
        if (data.is_max_thumb) {
            $('.alert-dismissable .close').trigger('click');
            eventSource.close();
            $('.page-content').prepend(data.msg);
        } else {
            $('#auto_thumbs .tools-bottom').hide();
        }
    }, false);

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