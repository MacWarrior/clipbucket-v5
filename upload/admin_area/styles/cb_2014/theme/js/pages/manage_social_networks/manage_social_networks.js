$(document).ready(function() {
    $('#hideshow').on('click', function () {
        $('#form_add_social_network').slideDown();
        $(this).fadeOut();
    });
    $('#cancel').on('click', function (e) {
        e.preventDefault();
        $('#form_add_social_network').slideUp();
        $('#hideshow').fadeIn();
    });

    $('.edit_social_network').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('.input-' + id).show();
        $('#ok-' + id).show();
        $('#remove-' + id).show();
        $('.edit-' + id).hide();
        $('#delete-' + id).hide();
        $('#edit-' + id).hide();
    });

    $('.cancel_social_network').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('.input-' + id).hide();
        $('#ok-' + id).hide();
        $('#remove-' + id).hide();
        $('.edit-' + id).show();
        $('#delete-' + id).show();
        $('#edit-' + id).show();
    });

    $('.confirm_update_social_network').on("click", function () {
        var _this = $(this);
        var id  = _this.data('id');
        var title = $('#input_title-' + id).val();
        var url = $('#input_url-' + id).val();
        var order = $('#input_order-' + id).val();
        var id_font_awesome = $('#input_id_fontawesome_icon-' + id).val();
        $.ajax({
            url: "/actions/admin_update_social_network.php",
            type: "post",
            dataType: 'json',
            data: {id_social_networks_link : id, title: title, url: url, social_network_link_order: order, id_fontawesome_icon: id_font_awesome},
            success: function (response) {
                $('#title_' + id).html(response.data.title);
                $('#url_' + id).html(response.data.url);
                $('#order_' + id).html(response.data.social_network_link_order);
                $('#icon_' + id + ' span.fa').removeClass().addClass('fa').addClass('fa-' + response.data.icon);
                $('#icon_' + id + ' span.text-icon').html(response.data.icon);


                $('.input-' + id).hide();
                $('#ok-' + id).hide();
                $('#remove-' + id).hide();
                $('#edit-' + id).show();
                $('.edit-' + id).show();
                $('#delete-' + id).show();
                $('.page-content').prepend(response.msg);
            }
        });
    });
    $('.delete_social_network').on("click", function () {
        var _this = $(this);
        if (confirm(lang_confirm_delete)) {
            var id  = _this.data('id');
            $.ajax({
                url: "/actions/admin_delete_social_network.php",
                type: "post",
                dataType: 'json',
                data: {id_social_networks_link : id},
                success: function () {
                    $('#tr_' + id).remove();
                }
            });
        }
    });

    $('.icon_select').select2({
        templateSelection: select2_format_icon,
        templateResult: select2_format_icon,
        allowHtml: true
    });
});

function select2_format_icon (icon) {
    return $('<span><i class="fa fa-' + icon.text + '"></i> ' + icon.text + '</span>');
}