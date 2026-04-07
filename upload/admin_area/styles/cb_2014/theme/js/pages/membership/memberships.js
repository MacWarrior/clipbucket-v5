$(function () {
    $('.delete').on('click', function () {
        if (_cb.confirm_it(text_confirm_delete)) {
            var id = $(this).data('id');
            var tr = $(this).parents('tr');
            $.post({
                url: '/actions/admin_delete_membership.php',
                data: {id_membership: id, redirect: false},
                dataType: "json",
                success: response => {
                    $('.page-content').prepend(response['msg']);
                    if (response['success']) {
                        tr.remove();
                    }
                }
            });
        }
    });
    $('.disabled_membership').on('change', function () {
        var id = $(this).data('id');
        var checked = $(this).prop('checked');
        $.post({
            url: '/actions/admin_activate_membership.php',
            data: {id_membership: id, disabled: !checked},
            dataType: "json",
            success: response => {

            }
        })
    });
});