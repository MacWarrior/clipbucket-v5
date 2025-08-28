let intervalId;
$(function () {
    if (ids_to_check_progress !== undefined && ids_to_check_progress.length > 0) {
        intervalId = setInterval(function () {
            $.post({
                url: admin_url + 'actions/video_progress.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: 'line'
                },
                success: function (response) {
                    var data = response.data.videos;

                    data.forEach(function (video) {
                        $('tr[data-id="' + video.videoid + '"').replaceWith(video.html);
                    });
                    if (response.all_complete) {
                        clearInterval(intervalId);
                    }
                }
            })
        }, 30000);
    }
});
