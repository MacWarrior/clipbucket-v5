$(() => {
    console.log('loaded');
    $('.unflag').on('click', function() {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        $.post({
            url: '/actions/admin_unflag_item.php',
            data: {id_flag_type: id_flag_type, id_element: id_element, type: type},
            dataType: "json",
        }).always(() =>  location.reload());
    });
    $('.delete_element').on('click', function() {
        const id_element = $(this).data('id-element');
        $.post({
            url: '/actions/admin_delete_flagged_item.php',
            data: {id_element: id_element, type: type},
            dataType: "json",
        }).always(() =>  location.reload());
    });
    $('.unflag_and_activate').on('click', function() {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        $.post({
            url: '/actions/admin_unflag_item.php',
            data: {id_flag_type: id_flag_type, id_element: id_element, type: type},
            dataType: "json",
        }).always(() =>  location.reload());
    });
    $('.details').on('click', function() {
        const id_flag_type = $(this).data('id-flag-type');
        const id_element = $(this).data('id-element');
        $.post({
            url: '/actions/admin_detail_flagged_item.php',
            data: {id_flag_type: id_flag_type, id_element: id_element, type: type},
            dataType: "json",
        }).always(() =>  location.reload());
    });
});