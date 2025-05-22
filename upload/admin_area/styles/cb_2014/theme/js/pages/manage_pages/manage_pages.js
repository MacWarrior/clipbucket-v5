let has_error = false;
$(document).ready(function () {
    $('#page_content').summernote();

    function removeErrClass(obj) {
        $(obj).closest('.form-group').removeClass('invalid-error');
        $(obj).closest('.form-group').removeClass('warning-ind');
        $(obj).next('span').remove();
    }

    $('input#page_name,input#page_title').on('keyup', function () {
        let input = $(this);
        let input_val = input.val();
        if (input_val === '') {
            addErrClass(input, errors["empty_"+input.attr('id')], true, false);
            has_error = true;
        } else if (input_val.indexOf(' ') >= 0 && input.attr('id') === 'page_name') {
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
});