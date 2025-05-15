let has_error = false;
$(document).ready(function () {
    $('#page_content').summernote();

    function removeErrClass(obj) {
        $(obj).closest('.form-group').removeClass('invalid-error');
        $(obj).closest('.form-group').removeClass('warning-ind');
        $(obj).next('span').remove();
    }

    $('input#page_name').on('keyup', function () {
        let page_name = $(this);
        let page_name_val = page_name.val();
        if (page_name_val === '') {
            addErrClass(page_name, errors["empty_name"], true, false);
            has_error = true;
        } else if (page_name_val.indexOf(' ') >= 0) {
            addErrClass(page_name, errors["page_name_cant_have_space"], true, false);
            has_error = true;
        } else {
            has_error = false;
        }
        if (!has_error) {
            removeErrClass(page_name);
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