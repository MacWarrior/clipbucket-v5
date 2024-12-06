$(function () {
    $('.add_new_email_template_list').on('click', ()=>{
        editEmailTemplate();
    })
});

function editEmailTemplate(email_template_id) {
    showSpinner();
    $.post({
        url: '/actions/admin_edit_email_template.php',
        data: {email_template_id: email_template_id},
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
        url: '/actions/admin_list_email_template.php',
        dataType: "json",
        success: (response) => {
            $('#email_template > .row').html(response.template);
            $('.page-content').prepend(response.msg);
            initListenerEdit();
        }
    }).always(() => hideSpinner());
}

var delay = 500;
var timeout
function initListenerEdit() {
    $('#email_template_content').on('keyup',  function () {
        var textarea = $(this);
        clearTimeout(timeout);
        timeout = setTimeout(()=>{
            $('#render').html(textarea.val());
        }, delay);
    });
}