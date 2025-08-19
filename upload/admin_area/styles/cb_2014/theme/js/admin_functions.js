//include('popup_image.js');
var page = admin_url + 'actions/admin.php';

function admin_spam_comment(cid) {
    $.post(page, {
            mode: 'spam_comment',
            cid: cid
        },
        function (data) {
            if (!data) {
                alert('No data');
            } else {
                if (data.msg) {
                    $('#comment_' + cid).removeClass('alert-info').addClass('alert-danger');
                    $('#spam_comment_' + cid).fadeOut(350, function () {
                        $('#remove_spam_comment_' + cid).fadeIn(350);
                    });
                }
                if (data.err) {
                    alert(data.err);
                }
            }
        }, 'json'
    );
}

function admin_remove_spam(cid) {
    $.post(page, {
            mode: 'remove_spam',
            cid: cid
        },
        function (data) {
            if (!data) {
                alert('No data');
            } else {
                if (data.msg) {
                    $('#comment_' + cid).removeClass('alert-danger').addClass('alert-info');
                    $('#remove_spam_comment_' + cid).fadeOut(350, function () {
                        $('#spam_comment_' + cid).fadeIn(350);
                    });
                }
                if (data.err) {
                    alert(data.err);
                }
            }
        }, 'json'
    );
}

function get_readable_filesize(bytes) {
    var size = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    var factor = Math.floor((bytes.toString().length - 1) / 3);
    var value = bytes / (1024 ** factor);
    value = Math.round(value * 100) / 100;

    return value + ' ' + size[factor];
}

function getModalUploadSubtitle(video_id) {
    showSpinner();
    $.ajax({
        url: admin_url + "actions/subtitle_popin_upload.php",
        type: "POST",
        data: {videoid: video_id},
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
