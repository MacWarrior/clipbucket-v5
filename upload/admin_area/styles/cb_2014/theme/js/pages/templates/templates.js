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
});