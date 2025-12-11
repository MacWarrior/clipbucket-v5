var loading_img = "<img style='vertical-align:middle' src='" + imageurl + "/ajax-loader.gif'>";
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
        $.ajax({
            url: admin_url + "actions/template_remove.php",
            type: "POST",
            data: {template_path: path},
            dataType: 'json',
            success: function (result) {
                $('.page-content').prepend(result['msg']);
                hideSpinner();
                if (result['success']) {
                    const urlObj = new URL(window.location);
                    urlObj.search = '';
                    window.location = urlObj.toString();
                }
            }
        });
    });

    $('.edit_theme').on('click', function (e) {
        const num = $(this).data('num');
        if ($('#description_group_' + num).hasClass('hidden')) {
            $('#description_group_' + num).removeClass('hidden');
            $('#description_text_' + num).addClass('hidden');
            $('#name_group_' + num).removeClass('hidden');
            $('#name_text_' + num).addClass('hidden');
            $(this).removeClass('text-primary');
        } else {
            $('#description_group_' + num).addClass('hidden');
            $('#name_group_' + num).addClass('hidden');
            $('#description_text_' + num).text($('#description_' + num).val()).removeClass('hidden');
            $('#name_text_' + num).text($('#name_' + num).val()).removeClass('hidden');
            $('#save_description_' + num+',#save_name_' + num).removeClass('glyphicon-ok glyphicon-remove').addClass('glyphicon-save');
            $(this).addClass('text-primary');
        }
    });

    $('.save_name').on('click', function (e) {
        if ($(this).hasClass('disabled')) {
            return;
        }
        e.preventDefault();
        saveField($(this), 'name');
    });
    $('.save_description').on('click', function (e) {
        if ($(this).hasClass('disabled')) {
            return;
        }
        e.preventDefault();
        saveField($(this), 'description');
    });

    function saveField(button, field) {
        const num = button.data('num');
        const path = $('#path_' + num).val();
        const value = $('#' + field + '_' + num).val();
        $.ajax({
            url: admin_url + 'actions/template_save_fields.php',
            type: "POST",
            data: {field: field, value: value, path: path},
            dataType: 'json',
            beforeSend: function () {
                button.removeClass('glyphicon-save glyphicon-ok glyphicon-remove glyphicon-refresh').html(loading_img);
            },
            success: function (result) {
                $('.page-content').prepend(result['msg']);
                if (result['success']) {
                    button.html('').removeClass('glyphicon-remove glyphicon-refresh').addClass('glyphicon-ok');
                } else {
                    button.html('').removeClass('glyphicon-refresh glyphicon-ok').addClass('glyphicon-remove');
                }
            }
        });
    }

});