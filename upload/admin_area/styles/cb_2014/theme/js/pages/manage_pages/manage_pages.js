let has_error = false;
$(function () {
    const pages = $('#pages_sortable');
    let previous_order;
    pages.sortable({
        items: '> .page-sortable',
        axis: 'y',
        distance: 5,
        helper: function (event, row) {
            row.children().each(function () {
                $(this).width($(this).width());
            });
            return row;
        },
        start: function () {
            previous_order = pages.children('.page-sortable').get();
        },
        update: function () {
            const page_ids = pages.children('.page-sortable').map(function () {
                return $(this).data('page-id');
            }).get();
            pages.sortable('disable');
            $.ajax({
                url: admin_url + 'actions/page_update_order.php',
                type: 'POST',
                dataType: 'json',
                data: {page_ids: page_ids},
                success: function (result) {
                    if (!result.success) {
                        pages.append(previous_order);
                    }
                    $('#page_order_message').html(result.msg);
                },
                error: function () {
                    pages.append(previous_order);
                    $('#page_order_message').text(errors.page_order);
                },
                complete: function () {
                    pages.sortable('enable');
                }
            });
        }
    });

    $('#page_content').summernote();

    function removeErrClass(obj) {
        $(obj).closest('.form-group').removeClass('invalid-error');
        $(obj).closest('.form-group').removeClass('warning-ind');
        $(obj).next('span').remove();
    }

    $('input#page_name').on('keyup', function () {
        let input = $(this);
        let input_val = input.val();
        if (input_val === '') {
            addErrClass(input, errors["empty_"+input.attr('id')], true, false);
            has_error = true;
        } else if (input_val.indexOf(' ') >= 0) {
            addErrClass(input, errors["page_name_cant_have_space"], true, false);
            has_error = true;
        } else {
            has_error = false;
        }
        if (!has_error) {
            removeErrClass(input);
        }
    });

    $('form').on('submit', function (e) {
        if (has_error) {
            e.preventDefault();
            return false;
        }
        $('#page_content').summernote('code', $('#page_content').summernote('code'));
    });

    $('.flag_language').on('click', function () {
        const id = $(this).data('id');
        $('#selected_lang').val(parseInt(id));
        $('.flag_language img').removeClass('selected');
        $('.flag_language[data-id="' + id + '"] img').addClass('selected');
        const form = $(this).parents('form');
        const textareas = form.find('textarea');
        textareas.hide();
        form.find('input[name^="page_title"]').hide();
        $('#page_content' + id).show();
        $('#page_title' + id).show();
    });
});
