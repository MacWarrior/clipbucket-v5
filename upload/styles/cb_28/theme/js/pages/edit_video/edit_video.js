$(function () {
    $("[id^=tags]").each(function(elem){
        init_tags(this.id, available_tags, '#list_'+this.id);
    });
    $('#list_video_users').tagit({
        singleField: true,
        fieldName: "tags",
        readOnly: false,
        singleFieldNode: $('#video_users'),
        animate: true,
        caseSensitive: false,
        allowSpaces: allow_username_spaces,
        beforeTagAdded: function (event,info) {
            if (info.tagLabel.length <= 2) {
                if (!alert_shown) {
                    alert_shown = true;
                    alert(tag_too_short);
                }
                return false;
            }
            alert_shown = false;
        }
    });

    $('[name="broadcast"]').off('click').on('click', function () {
        if ($(this).val() === 'unlisted') {
            $(this).closest('form').find('#video_password').attr('disabled', false).parent().slideDown();
            $(this).closest('form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
        } else if ($(this).val() === 'private') {
            $(this).closest('form').find('#video_users').attr('disabled', false).parent().slideDown();
            $(this).closest('form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
        } else {
            $(this).closest('form').find('#video_password').attr('disabled', 'disabled').parent().slideUp();
            $(this).closest('form').find('#video_users').attr('disabled', 'disabled').parent().slideUp();
        }
    }).trigger('click');
    $('#button_info_tmdb').on('click', function (e) {
        var video_title = $('#title').val();
        getInfoTmdb(videoid, 'movie',video_title, 1);
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
function getInfoTmdb(video_id, type, video_title, page,sort, sort_order,selected_year) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/info_tmdb.php",
        type: "POST",
        data: {videoid: video_id, video_title:video_title, type: type, page: page,sort: sort, sort_order: sort_order,selected_year },
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

function saveInfoTmdb(tmdb_video_id, type) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/import_tmdb.php",
        type: "POST",
        data: {tmdb_video_id: tmdb_video_id, videoid: videoid, type: type},
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

    getInfoTmdb(videoid, $('#type_tmdb').val(), $('#search_title').val(), page, sort_type, sort,$('#selected_year').val());
}

function showSpinner() {
    $('.taskHandler').show();
}

function hideSpinner() {
    $('.taskHandler').hide();
}

function editTitle(number) {
    $('#buttons-' + number).css('display', 'inline');
    $('#edit_sub_' + number).css('display', 'inline');
    $('#span_sub_' + number).hide();
}

function cancelEditTitle(number) {
    $('#buttons-' + number).hide();
    $('#edit_sub_' + number).hide();
    $('#span_sub_' + number).show();
}
function saveSubtitle(number) {
    $.ajax({
        url: baseurl+"actions/subtitle_edit.php",
        type: "POST",
        data: {title: $('#edit_sub_' + number).val(), videoid: videoid, number: number},
        dataType: 'json',
        success: function (result) {
            $('#subtitiles').html(result['template']);
            $('.close').click();
            $('.page-content').prepend(result['msg']);
        }
    });
}
