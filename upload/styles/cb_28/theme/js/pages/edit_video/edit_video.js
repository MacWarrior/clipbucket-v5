$(function () {
    $("[id^=tags]").each(function(elem){
        init_tags(this.id, available_tags, '#list_'+this.id);
    });
    $('#button_info_tmdb').on('click', function (e) {
        var video_title = $('#title').val();
        getInfoTmdb(videoid, video_title, 1);
    })
});
function getInfoTmdb(video_id, video_title, page,sort, sort_order) {
    showSpinner();
    $.ajax({
        url: "/actions/info_tmdb.php",
        type: "POST",
        data: {videoid: video_id, video_title:video_title, page: page,sort: sort, sort_order: sort_order },
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.page-content').prepend(result['msg']);
        }
    });
}

function saveInfoTmdb(tmdb_video_id) {
    showSpinner();
    $.ajax({
        url: "/actions/import_tmdb.php",
        type: "POST",
        data: {tmdb_video_id: tmdb_video_id, videoid: videoid},
        dataType: 'json',
        success: function (result) {
            if (result.success == false) {
                $('.close').click();
                hideSpinner();
                $('.page-content').prepend(result['msg']);
            } else {
                location.reload();
            }
        },
    });
}

function pageInfoTmdb(page) {
    let sort_type;
    let sort;
    if ($('.icon-sort-up').length > 0) {
        sort_type = $('.icon-sort-up').data('type');
        sort = 'ASC';
    } else if ($('.icon-sort-down').length > 0) {
        sort_type = $('.icon-sort-down').data('type');
        sort = 'DESC';
    }

    getInfoTmdb(videoid, $('#search_title').val(), page, sort_type, sort);
}

function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}
