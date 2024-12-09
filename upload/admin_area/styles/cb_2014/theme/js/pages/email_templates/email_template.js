$(function () {
    initListenerList();

});

function editEmailTemplate(email_template_id) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_edit.php',
        data: {email_template_id: email_template_id},
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEdit();
        }
    }).always(() => hideSpinner());
}

function saveEmailTemplate(form) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_save.php',
        data: form.serialize(),
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEdit();
        }
    }).always(() => hideSpinner());
}

function listEmailTemplate() {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_list.php',
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerList();
        }
    }).always(() => hideSpinner());
}

var delay = 500;
var timeout;

function initListenerEdit() {
    $('#email_template_content').off('keyup').on('keyup', function () {
        var textarea = $(this);
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $('#render').html(textarea.val());
        }, delay);
    });

    $('#email_template_edit').off('submit').on('submit', function (event) {
        event.preventDefault();
        saveEmailTemplate($(this));
    });

    $('.back_to_template_list').off('click').on('click', () => {
        listEmailTemplate();
    })

}

function initListenerList() {
    $('.add_new_email_template_list').off('click').on('click', () => {
        editEmailTemplate();
    });
    $('input[name="make_default"]').change(function (e) {
        if (confirm(confirm_default_template)) {
            showSpinner();
            $('input[name="make_default"]').not(this).prop('checked', false);
            $.ajax({
                url: "/actions/admin_email_make_default.php",
                type: "POST",
                data: $('#default_template').serialize(),
                dataType: 'json',
                success: function (result) {
                    $('#email_template > .row').html(result.template);
                    $('.page-content').prepend(result.msg);
                    initListenerList();
                }
            }).always(() => hideSpinner());
        } else {
            $(this).prop('checked', false)
        }
        
    });
}