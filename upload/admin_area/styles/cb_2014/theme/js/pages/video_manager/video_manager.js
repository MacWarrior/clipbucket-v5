let intervalId;
$(function () {
    if (ids_to_check_progress) {
        intervalId = setInterval(function () {
            $.post({
                url: '/actions/admin_progress_video.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: 'html'
                },
                success: function (response) {
                    var data = response.data;

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
