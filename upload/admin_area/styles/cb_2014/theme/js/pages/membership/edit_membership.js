$(function () {
    $('.delete').on('click', function () {
        if (_cb.confirm_it('Are you sure you want to delete')) {
            var id = $(this).data('id');
            var tr = $(this).parents('tr');
            $.post({
                url: '/actions/admin_delete_membership.php',
                data: {id_membership: id, redirect: true},
                dataType: "json",
                success: response => {
                    document.location = response.url;
                }
            });
        }
    });

    $('#currency').select2({
    });
});