$(function () {
    $('.copy_default_theme').on('click', function (e) {
        showSpinner();
        $.ajax({
            url: admin_url + "actions/template_copy_default.php",
            type: "POST",
            dataType: 'json',
            success: function (result) {
                $('.page-content').prepend(result['msg']);
                window.location.reload();
            }
        });
    });

    $('.delete_default_theme').on('click', function (e) {
        $('#delete_code_modal').modal();
        $('#delete_code_modal').find('#delete_num').val($(this).data('num'));
    });

    $('.confirm_delete').on('click', function (e) {
        showSpinner();
        const num = $('#delete_num').val();
        const path = $('#path_' + num).val();
        console.log(path);
        $.ajax({
            url: admin_url + "actions/template_remove.php",
            type: "POST",
            data: {template_path: path},
            dataType: 'json',
            success: function (result) {
                $('.page-content').prepend(result['msg']);
                window.location.reload();
            }
        });
    });

});