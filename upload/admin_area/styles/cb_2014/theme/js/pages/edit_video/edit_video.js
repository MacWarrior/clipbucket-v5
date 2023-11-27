function regenerateThumbs(videoid) {
    $.ajax({
        url: "/actions/regenerate_thumbs.php",
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
            url: "/actions/resolution_delete.php",
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
            url: "/actions/subtitle_delete.php",
            type: "POST",
            data: {number: number, videoid: videoid},
            dataType: 'json',
            success: function (result) {
                $('#subtitiles').html(result['template']);
                $('.close').click();
                $('.page-content').prepend(result['msg']);
            }
        });
    }
}

function editTitle(number) {
    $('#buttons-' + number).css('display', 'inline');
    $('#edit_sub_' + number).css('display', 'inline');
}

function cancelEditTitle(number) {
    $('#buttons-' + number).hide();
    $('#edit_sub_' + number).hide();
}

function saveSubtitle(number) {
    $.ajax({
        url: "/actions/subtitle_edit.php",
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
$(function () {
    init_tags('tags', available_tags);
});