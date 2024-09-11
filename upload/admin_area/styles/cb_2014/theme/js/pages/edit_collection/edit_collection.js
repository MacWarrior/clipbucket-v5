$(function () {
    init_tags('collection_tags', available_tags);

    $('.del_cmt').on('click', function () {
        var id = $(this).data('id');
        deleteComment(id);
    });
});

function deleteComment(comment_id) {
    if (confirm_it(text_confirm_comment)) {
        $.ajax({
            url: "/actions/admin_comment_delete.php",
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
                    $('#clcomments .form-group').html(text_no_comment);
                }
            }
        });
    }
}