var loading_img = "<img style='vertical-align:middle' src='" + imageurl + "/ajax-loader.gif'>";

function format_date_to_display(date) {
    return $.datepicker.formatDate(format_display, date);
}

$(function () {

    $('.toDatepicker').datepicker({
        showOtherMonths: true,
        selectOtherMonths: false,
        changeMonth: true,
        dateFormat: format_date_js,
        changeYear: true,
        yearRange: "-99y:+0",
        regional: language
    });


    $('[id^="released_text_"]').each(function (index, elem) {
        const date = new Date($(this).siblings('.hidden_released').val());
        $(this).text(format_date_to_display(date));
    });
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
            $('.input-group[id$=' + num + ']').removeClass('hidden');
            $('[id$="text_' + num + '"]').addClass('hidden');
            $(this).removeClass('text-primary');
        } else {
            $('.input-group[id$=' + num + ']').each(function (index, elem) {
                const field = $(this).attr('id').match(/(\w+)_group_\d+/)[1];
                let val = $(this).find('input').val();
                if (field === 'released') {
                    val = format_date_to_display(new Date(val));
                }

                $(this).addClass('hidden');
                const text_element = $('#' + field + '_text_' + num + '');
                if (field === 'author') {

                }
                if (field === 'link') {
                    text_element.attr('href', val);
                    $('#author_text_' + num).attr('href', val);
                } else {
                    text_element.text(val);
                }
                text_element.removeClass('hidden');
                $('.save_'+field).removeClass('glyphicon-ok glyphicon-remove').addClass('glyphicon-save').attr('title', lang['save']);
            });
            $(this).addClass('text-primary');
        }
    });

    $('.save_template_field').on('click', function (e) {
        if ($(this).hasClass('disabled')) {
            return;
        }
        e.preventDefault();
        saveField($(this), $(this).attr('id').match(/save_(\w+)_\d+/)[1]);
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