let intervalId;
$(function () {
    if (ids_to_check_progress !== undefined && ids_to_check_progress.length > 0) {
        intervalId = setInterval(function () {
            $.post({
                url: 'actions/progress_conversion_queue.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress
                },
                success: function (response) {
                    var data = response.data.cqueues;

                    data.forEach(function (cqueue) {
                        $('tr[data-id="' + cqueue.cqueue_id + '"').html(cqueue.html);
                    });
                    if (response.all_complete) {
                        clearInterval(intervalId);
                    }
                }
            })
        }, 30000);
    }
});
