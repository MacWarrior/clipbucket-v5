
$(function () {
    init_tags('tags', available_tags);
    $('#collection_id').select2({
        width: '100%'
    });

    $('#edit_photo').on('submit', function (e) {
        if ($('#collection_id').val() === null) {
            $('a[href="#photodetails"]').trigger('click');
            $('#collection_id + .select2-container .select2-selection--single').css('border-color','red') ;
            e.preventDefault();
            return false;
        }
    });
    $('.del_cmt').on('click', function () {
        var id = $(this).data('id');
        deleteComment(id);
    });

});
function deleteComment(comment_id) {
    if (confirm_it(text_confirm_comment)) {
        $.ajax({
            url: baseurl+"actions/admin_comment_delete.php",
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