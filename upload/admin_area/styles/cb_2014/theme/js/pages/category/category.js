function addOrEdit(category_id) {
    $("#edit_category").trigger('reset');
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
    });
    $('html, body').animate({
        scrollTop: 0
    }, 800);
}

$(function () {
    if (category_id !== '') {
        addOrEdit(category_id);
        $('#hideshow').hide();
    }
    $('#hideshow').on('click', function () {
        addOrEdit();
    });
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
