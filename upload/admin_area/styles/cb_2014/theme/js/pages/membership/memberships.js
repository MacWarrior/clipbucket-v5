$(function () {
    $('.delete').on('click', function () {
        if (_cb.confirm_it('Are you sure you want to delete)')) {
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
    $('.activate').on('click', function () {
        var id = $(this).data('id');
        $.post({
            url: 'actions/admin_membership_activate.php',
            data: {id_membership: id, disabled: false},
            dataType: "json",
            success: response => {

            }
        })
    });
    $('.deactivate').on('click', function () {
        var id = $(this).data('id');
        $.post({
            url: 'actions/admin_membership_activate.php',
            data: {id_membership: id, disabled: true},
            dataType: "json",
            success: response => {

            }
        })
    });
});