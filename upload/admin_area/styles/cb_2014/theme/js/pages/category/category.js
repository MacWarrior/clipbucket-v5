function addOrEdit(category_id) {
    $("#edit_category").trigger('reset');
    showSpinner();
    $.ajax({
        url: "/actions/form_category.php",
        type: "post",
        data: {'category_id': category_id, 'type': type},
        dataType: 'json'
    }).done(function (result) {
        $('#content').html(result['template']);
        $('.page-content').prepend(result['msg']);
        $('#hideshow').hide();
        $('#cancel').on('click', function (e) {
            e.preventDefault();
            $('#hideshow').show();
            $('#content').html('');
        });
    }).always(hideSpinner);
    $('html, body').animate({
        scrollTop: 0
    }, 800);
}

function initListenerList() {
    $('[name="make_default"]').on('change', function (e) {
        showSpinner();
        $('input[name="make_default"]').not(this).prop('checked', false);
        $.ajax({
            url: "/actions/category_make_default.php",
            type: "POST",
            data: {'category_id': $(this).val(), type: type},
            dataType: 'json',
            success: function (result) {
                $('#category_list').html(result['template']);
                $('.page-content').prepend(result['msg']);
                initListenerList();
            }
        }).always(hideSpinner);
    });
}

$(function () {
    if (category_id !== '') {
        addOrEdit(category_id);
        $('#hideshow').hide();
    }
    $('#hideshow').on('click', function () {
        addOrEdit();
    });
    initListenerList();
    $('body').on('click', function (e) {
        $('[data-toggle="popover"]').each(function () {
            //the 'is' for buttons that trigger popups
            //the 'has' for icons within a button that triggers a popup
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
    });

});
