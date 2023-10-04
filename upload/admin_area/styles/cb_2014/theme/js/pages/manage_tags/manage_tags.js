$(document).ready(function () {
    $('.edit_tag').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('#input-' + id).show();
        $('#ok-' + id).show();
        $('#cancel-' + id).show();
        $('#delete-' + id).hide();
        $('#edit-' + id).hide();
    });

/*    $('.input_tag').on('input', function () {
        if ($(this).val().length <= 2) {
            $('#ok-' + $(this).data('id')).prop('disabled',true).removeClass('text-success').addClass('text-muted');
            $(this).addClass('error');
        } else {
            $('#ok-' + $(this).data('id')).prop('disabled',false).removeClass('text-muted').addClass('text-success');
            $(this).removeClass('error');
        }
    });*/

    $('.delete_tag').on("click", function () {
            var _this = $(this);
            if (_this.hasClass('disabled')) {
                return false;
            }
            var id = _this.data('id');
            var value = $('#input-' + id).val();
        if (confirm_it(text_confirm_delete_tag.replace('%s', value))) {
            $.ajax({
                url: "/actions/tag_delete.php",
                type: "POST",
                data: {id_tag: id},
                dataType: 'json',
                success: function (result) {
                    $('.close').click();
                    $('.page-content').prepend(result['msg']);
                    _this.parents('tr').remove();
                }
            });
        }
    });

    $('.cancel_tag').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('#input-' + id).hide();
        $('#ok-' + id).hide();
        $('#cancel-' + id).hide();
        $('#delete-' + id).show();
        $('#edit-' + id).show();
    });

    $('.confirm_update_tag').on("click", function () {
        var _this = $(this);
        if (_this.prop('disabled') === true) {
            return false;
        }
        var id = _this.data('id');
        var value = $('#input-' + id).val();
        $.ajax({
            url: "/actions/tag_update.php",
            type: "post",
            dataType: 'json',
            data: {id_tag: id, tag: value},
            success: function (result) {
                $('.close').click();
                $('.page-content').prepend(result['msg']);
                if (result['success']) {
                    $('#' + id).html(value);
                    $('#input-' + id).hide();
                    $('#ok-' + id).hide();
                    $('#cancel-' + id).hide();
                    $('#delete-' + id).show();
                    $('#edit-' + id).show();
                }
            }
        });
    });
});
