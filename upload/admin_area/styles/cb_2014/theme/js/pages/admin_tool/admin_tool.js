$(function () {
    $('.launch').on('click', function () {
        var elem = $(this);
        if (!elem.parent().hasClass('disabled')) {
            var id_tool = $(this).data('id');
            $.ajax({
                url: "/actions/launch_tool.php",
                type: "POST",
                data: {id_tool: id_tool},
                dataType: 'json',
                success: function (result) {
                    $('#progress-' + id_tool).show();
                    $('#progress-bar-' + id_tool).attr('aria-valuenow', 0);
                    $('#span-' + id_tool).html(result['libelle_status']);
                    $('.page-content').prepend(result['msg']);
                    elem.parent().addClass('disabled');
                    $('.stop[data-id="' + id_tool + '"]').parent().removeClass('disabled');
                }
            });
        }
    });
    $('.stop').on('click', function () {
        var elem = $(this);
        if (!$(this).parent().hasClass('disabled')) {
            var id_tool = elem.data('id');
            $.ajax({
                url: "/actions/stop_tool.php",
                type: "POST",
                data: {id_tool: id_tool},
                dataType: 'json',
                success: function (result) {
                    $('#span-' + id_tool).html(result['libelle_status']);
                    elem.parent().addClass('disabled');
                    $('.page-content').prepend(result['msg']);
                }
            });
        }
    });
});