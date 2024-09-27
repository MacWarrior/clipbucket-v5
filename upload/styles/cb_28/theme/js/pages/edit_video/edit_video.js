$(function () {
    $("[id^=tags]").each(function(elem){
        init_tags(this.id, available_tags, '#list_'+this.id);
    });
    $('#button_info_tmdb').on('click', function (e) {
        var video_title = $('#title').val();
        getInfoTmdb(videoid, video_title, 1);
    });
    $('.formSection h4').on({
        click: function(e){
            e.preventDefault();
            if($(this).find('i').hasClass('glyphicon-chevron-down')){
                $(this).find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                $(this).next().toggleClass('hidden');
            }else{
                $(this).find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                $(this).next().toggleClass('hidden');
            }
        }
    });

    $('#upload_thumbs').on('click', function (e) {
        e.preventDefault();
        var fd = new FormData();

        $.each($('#new_thumbs')[0].files, function(i, file) {
            fd.append('vid_thumb[]', file);
        });
        $.ajax(
            'upload_thumb.php?video=' + videoid
            , {
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: fd
                , success: function (data) {
                    // location.reload();
                }
            }
        )
    });

    $('#upload_thumbs_poster').on('click', function (e) {
        e.preventDefault();
        var fd = new FormData();

        $.each($('#new_thumbs_poster')[0].files, function(i, file) {
            fd.append('vid_thumb_poster[]', file);
        });
        $.ajax(
            'upload_thumb.php?video=' + videoid
            , {
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: fd
                , success: function () {
                    location.reload();
                }
            }
        )
    });

    $('#upload_thumbs_backdrop').on('click', function (e) {
        e.preventDefault();
        var fd = new FormData();

        $.each($('#new_thumbs_backdrop')[0].files, function(i, file) {
            fd.append('vid_thumb_backdrop[]', file);
        });
        $.ajax(
            'upload_thumb.php?video=' + videoid
            , {
                type: 'POST',
                contentType: false,
                processData: false,
                cache: false,
                data: fd
                , success: function (data) {
                    location.reload();
                }
            }
        )
    });
});
function getInfoTmdb(video_id, video_title, page,sort, sort_order,selected_year) {
    showSpinner();
    $.ajax({
        url: "/actions/info_tmdb.php",
        type: "POST",
        data: {videoid: video_id, video_title:video_title, page: page,sort: sort, sort_order: sort_order,selected_year },
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

    getInfoTmdb(videoid, $('#search_title').val(), page, sort_type, sort,$('#selected_year').val());
}

function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}
