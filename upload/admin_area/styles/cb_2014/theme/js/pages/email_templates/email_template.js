$(function () {
    initListenerEmailTemplateList();
    initListenerEmailList();
    initListenerEmailTester();
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
            updateSelect('email_id_email_template', response.email_template_list, 'email_template');
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
            updateSelect('select_email', response.email_list, 'email');
        }
    }).always(() => hideSpinner());
}

function deleteEmailTemplate(id_email_template) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_template_delete.php',
        data: {id_email_template: id_email_template},
        dataType: "json",
        success: (response) => {
            $('.page-content').prepend(response.msg);
            listEmailTemplate();
            updateSelect('email_id_email_template', response.email_template_list, 'email_template');
        }
    });
}

function deleteEmail(id_email) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_delete.php',
        data: {id_email: id_email},
        dataType: "json",
        success: (response) => {
            $('.page-content').prepend(response.msg);
            listEmail();
            updateSelect('select_email', response.email_list, 'email');
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

function listEmail(search) {
    showSpinner();
    $.post({
        url: '/actions/admin_email_list.php',
        dataType: "json",
        data: {search: search},
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
    $('#email_template_content').on('keyup', function () {
        let email_content = $(this).val();
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            $.post({
                url: '/actions/admin_email_template_render.php',
                data: {
                    email_content: email_content
                },
                dataType: "json",
                success: (response) => {
                    $('#render').html(response.email_render);
                }
            });
        }, delay);
    });

    $('#email_template_edit').on('submit', function (event) {
        event.preventDefault();
        saveEmailTemplate($(this));
    });

    $('.back_to_template_list').on('click', () => {
        listEmailTemplate();
    })
}

function initListenerEmailTemplateList() {
    $('.add_new_email_template_list').on('click', () => {
        editEmailTemplate();
    });
    $('input[name="make_default"]').change(function (e) {
        if (confirm(confirm_default_template)) {
            showSpinner();
            $('input[name="make_default"]').not(this).prop('checked', false);
            $.post({
                url: "/actions/admin_email_make_default.php",
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
    $('#email_id_email_template').on('change', function () {
        refreshRenderEmail();
    });

    $('#email_content').on('keyup', function () {
        refreshRenderEmail();
    });

    $('#email_edit').on('submit', function (event) {
        event.preventDefault();
        saveEmail($(this));
    });

    $('.back_to_email_list').on('click', () => {
        listEmail();
    })
}

function refreshRenderEmail()
{
    let email_content = $('#email_content').val();
    let id_email_template = $('#email_id_email_template').val();
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        $.post({
            url: '/actions/admin_email_render.php',
            data: {
                email_content: email_content
                ,id_email_template: id_email_template
            },
            dataType: "json",
            success: (response) => {
                $('#render_email').html(response.email_render);
            }
        });
    }, delay);
}

function initListenerEmailList() {
    $('.add_new_email_list').on('click', () => {
        editEmail();
    });

    $('.search_email').on('click', () => {
        var search = $('#search').val();
        listEmail(search);
    });
}

function displayVariable(id_email) {
    showSpinner();
    $.post({
        url: '/actions/admin_display_variables.php',
        dataType: 'json',
        data: {id_email: id_email},
        success: function (response) {
            $('#edit_variable').html(response.template);
            $('.page-content').prepend(response.msg);
        }
    }).always(() => hideSpinner());
}

function initListenerEmailTester() {
    $('#select_email').on('change', function () {
        displayVariable($(this).val());
    });

    $('.send_email').on('click', function (e) {
        e.preventDefault();
        hideSpinner();
        $.post({
            url: '/actions/admin_email_tester_send.php',
            dataType: 'json',
            data: $('#email_tester_form').serialize(),
            success: function (response) {
                $('.page-content').prepend(response.msg);
            }
        }).always(() => hideSpinner());
    });
}

function updateSelect(select_id, options, type) {
    var id;
    var text;
    $('#' + select_id + ' option').remove();
    $.each(options, function (i, item) {
        if (type == 'email') {
            id = item.id_email;
            text = item.code + ' - ' + item.title;
        } else if (type =='email_template') {
            id = item.id_email_template;
            text = item.code;
        }
        $('#' + select_id).append($('<option>', {
            value: id,
            text: text
        }));
    })
}
