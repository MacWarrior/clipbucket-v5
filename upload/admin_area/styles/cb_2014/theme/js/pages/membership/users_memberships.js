$(function () {
    $('.fa-sort').parent().on('click', function () {
        $('#sort').val($(this).children().first().data('type'));
        $('#sort_order').val('ASC');
        $('#users_memberships_search').trigger('submit');
    });
    $('.fa-sort-up').parent().on('click', function () {
        $('#sort').val($(this).children().first().data('type'));
        $('#sort_order').val('DESC');
        $('#users_memberships_search').trigger('submit');
    });
    $('.fa-sort-down').parent().on('click', function () {
        $('#sort').val($(this).children().first().data('type'));
        $('#sort_order').val('ASC');
        $('#users_memberships_search').trigger('submit');
    });

    $('.show_log').on('click', function () {
        getMembershipHistory(userid, 1)
    });
});

function getMembershipHistory(userid, page) {
    showSpinner();
    $.ajax({
        url: "/actions/admin_get_membership_history.php",
        type: "POST",
        data: {userid: userid, page: page},
        dataType: 'json',
        success: function (result) {
            // Create new event, the server script is sse.php
            $('.page-content').prepend(result['msg']);
            $('#myModal').html(result['template']);
            $('#myModal').modal();
            hideSpinner();
        }
    });
}

function pageViewHistory(page) {
    getMembershipHistory(userid, page);
}