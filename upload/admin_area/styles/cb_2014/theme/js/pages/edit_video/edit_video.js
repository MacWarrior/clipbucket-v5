function regenerateThumbs(videoid) {
    $.ajax({
        url: "actions/thumbs_regenerate.php",
        type: "post",
        data: {videoid: videoid, origin: 'edit_video'},
        dataType: 'json',
        beforeSend: function(){
            showSpinner();
        },
        success: function(response){
            $('#thumbnails').html(response['template']);
            $('.page-content').prepend(response['msg']);

            videojs($('#player').find('video')[0]).dispose();
            setTimeout(function(){
                $('#player').html(response['player']);
                hideSpinner();
            }, 200);
        }
    });
}

function deleteResolution(resolution) {
    if (confirm_it(text_confirm_vid_file.replace('%s', resolution))) {
        $.ajax({
            url: "actions/resolution_delete.php",
            type: "POST",
            data: {resolution: resolution, videoid: videoid},
            dataType: 'json',
            success: function (result) {
                $('#resolutions').html(result['template']);
                $('.close').click();
                $('.page-content').prepend(result['msg']);
            }
        });
    }
}

function deleteSubtitle(number) {
    if (confirm_it(text_confirm_sub_file.replace('%s', number))) {
        $.ajax({
            url: "actions/subtitle_delete.php",
            type: "POST",
            data: {number: number, videoid: videoid},
            dataType: 'json',
            success: function (result) {
                $('#subtitles').html(result['template']);
                $('.close').click();
                $('.page-content').prepend(result['msg']);
            }
        });
    }
}

function deleteComment(comment_id) {
    if (confirm_it(text_confirm_comment)) {
        $.ajax({
            url: "actions/comment_delete.php",
            type: "POST",
            data: {comment_id: comment_id},
            dataType: 'json',
            success: function (result) {
                $('.page-content').prepend(result['msg']);
                if (result['success']) {
                    $('#comment_' + comment_id).remove();
                }
                var lines = $('.comment_line');
                if (lines.length === 0 ) {
                    $('#comments .form-group').html(text_no_comment);
                }
            }
        });
    }
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

    showSpinner();
    $.ajax({
        url: "actions/subtitle_edit.php",
        type: "POST",
        data: {title: $('#edit_sub_' + number).val(), videoid: videoid, number: number},
        dataType: 'json',
        success: function (result) {
            $('#subtitles').html(result['template']);
            hideSpinner();
            $('.close').click();
            $('.page-content').prepend(result['msg']);
        }
    });
}

function getInfoTmdb(video_id, type, video_title, page,sort, sort_order, selected_year) {
    showSpinner();
    $.ajax({
        url:"actions/tmdb_info.php",
        type: "POST",
        data: {videoid: video_id, video_title: video_title, type: type, page: page,sort: sort, sort_order: sort_order, selected_year: selected_year },
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
        url: "actions/tmdb_import.php",
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

    getInfoTmdb(videoid, $('#type_tmdb').val(),$('#search_title').val(), page, sort_type, sort,$('#selected_year').val());
}


function getViewHistory(video_id, page) {
    showSpinner();
    $.ajax({
        url: "actions/video_view_history.php",
        type: "POST",
        data: {videoid: video_id, page: page, modal: false },
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            $('#view_history_div').html(result['template']);
            $('.page-content').prepend(result['msg']);
        }
    });
}

function pageViewHistory(page) {
    getViewHistory(videoid, page);
}

$( document ).ready(function() {
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

    $('#button_info_tmdb').on('click', function () {
        var video_title = $('#title').val();
        getInfoTmdb(videoid, 'movie',video_title, 1);
    });

    $('.del_cmt').on('click', function () {
        var id = $(this).data('id');
        deleteComment(id);
    });

    $('.poster li').click(function(){
            $('.poster li.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    );
    $('.backdrop li').click(function(){
            $('.backdrop li.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    );
    $('.thumb li').click(function(){
            $('.thumb li.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    );

    if( visual_editor_comments_enabled ){
        Array.from(document.querySelectorAll('#comments .itemdiv .body .col-md-7 span')).forEach((comment,index) => {
            new toastui.Editor.factory({
                el: comment,
                viewer: true,
                usageStatistics: false,
                initialValue: comment.innerHTML
            });
        });
    }

    if (ids_to_check_progress.length > 0) {
        intervalId = setInterval(function () {
            $.post({
                url: 'actions/video_progress.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: 'edit'
                },
                success: function (response) {
                    var data = response.data;

                    data.videos.forEach(function (video) {
                        $('#videoplayer').html(video.html)
                        $('#status').val(video.data.status)
                    });

                    if (response.all_complete) {
                        clearInterval(intervalId);
                    }
                }
            })
        }, 30000);
    }

    $('#datecreated').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat: format_date_js,
        changeYear: true,
        yearRange: "-99y:+0",
        regional: language
    });
});
