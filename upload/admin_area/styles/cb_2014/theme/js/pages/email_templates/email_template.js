$(function () {
    initListenerEmailTemplateList();
    initListenerEmailList();
});

function editEmailTemplate(id_email_template) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_edit.php',
        data: {id_email_template: id_email_template},
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEmailTemplateEdit();
        }
    }).always(() => hideSpinner());
}
function editEmail(id_email) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_edit.php',
        data: {id_email: id_email},
        dataType: "json",
        success: (response) => {
            $('#email > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEmailEdit();
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
            initListenerEmailTemplateEdit();
        }
    }).always(() => hideSpinner());
}
function saveEmail(form) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_save.php',
        data: form.serialize(),
        dataType: "json",
        success: (response) => {
            $('#email > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEmailEdit();
        }
    }).always(() => hideSpinner());
}

function deleteEmailTemplate (id_email_template) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_delete.php',
        data: {id_email_template: id_email_template},
        dataType: "json",
        success: (response) => {
            $('.page-content').prepend(response.msg);
            listEmailTemplate();
        }
    });
}
function deleteEmail (id_email) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_delete.php',
        data: {id_email: id_email},
        dataType: "json",
        success: (response) => {
            $('.page-content').prepend(response.msg);
            listEmail();
        }
    });
}

function listEmailTemplate() {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_list.php',
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEmailTemplateList();
        }
    }).always(() => hideSpinner());
}
function listEmail() {
    showSpinner();
    $.post({
        url: '/actions/admin_email_list.php',
        dataType: "json",
        success: (response) => {
            $('#email > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEmailList();
        }
    }).always(() => hideSpinner());
}

var delay = 500;
var timeout;

function initListenerEmailTemplateEdit() {
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

function initListenerEmailTemplateList() {
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
                    initListenerEmailTemplateList();
                }
            }).always(() => hideSpinner());
        } else {
            $(this).prop('checked', false)
        }
        
    });
}

function initListenerEmailEdit() {
    $('#email_content').off('keyup').on('keyup', function () {
        var textarea = $(this);
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $('#render_email').html(textarea.val());
        }, delay);
    });

    $('#email_edit').off('submit').on('submit', function (event) {
        event.preventDefault();
        saveEmail($(this));
    });

    $('.back_to_email_list').off('click').on('click', () => {
        listEmail();
    })

}


function initListenerEmailList() {
    $('.add_new_email_list').off('click').on('click', () => {
        editEmail();
    });
}