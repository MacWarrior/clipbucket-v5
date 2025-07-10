$(() => {
    $('.unflag').on('click', function () {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        $.post({
            url: 'actions/item_unflag.php',
            data: {id_flag_type: id_flag_type, id_element: id_element, type: type},
            dataType: "json",
        }).always(() => location.reload());
    });
    $('.delete_element').on('click', function () {
        const id_element = $(this).data('id-element');
        $.post({
            url: 'actions/item_delete_flagged.php',
            data: {id_element: id_element, type: type},
            dataType: "json",
        }).always(() => location.reload());
    });
    $('.unflag_and_activate').on('click', function () {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        $.post({
            url: 'actions/item_unflag.php',
            data: {id_flag_type: id_flag_type, id_element: id_element, type: type},
            dataType: "json",
        }).always(() => location.reload());
    });
    $('.details').on('click', function () {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        showDetail(id_flag_type, id_element, type, 1)
    });
});

function showDetail(id_flag_type, id_element, type, page) {
    showSpinner();
    $.ajax({
        url: "actions/item_get_detail_flagged.php",
        type: "POST",
        data: {id_flag_type: id_flag_type, id_element: id_element, type: type, page: page},
        dataType: 'json',
        success: function (result) {
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.page-content').prepend(result['msg']);
        }
    }).always(() => hideSpinner());
}
