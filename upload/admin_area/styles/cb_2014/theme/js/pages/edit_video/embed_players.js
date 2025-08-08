$(document).ready(function() {
    $('#hideshow').on('click', function (e) {
        e.preventDefault();
        $('#form_add_embed_player').slideDown();
        $(this).fadeOut();
    });
    $('#cancel').on('click', function (e) {
        e.preventDefault();
        $('#form_add_embed_player').slideUp();
        $('#hideshow').fadeIn();
    });

    $('.edit_embed_player').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('.input-' + id).show();
        $('#ok-' + id).show();
        $('#remove-' + id).show();
        $('.edit-' + id).hide();
        $('#delete-' + id).hide();
        $('#edit-' + id).hide();
    });

    $('.cancel_embed_player').on("click", function () {
        var _this = $(this);
        var id = _this.data('id');
        $('.input-' + id).hide();
        $('#ok-' + id).hide();
        $('#remove-' + id).hide();
        $('.edit-' + id).show();
        $('#delete-' + id).show();
        $('#edit-' + id).show();
    });

    let embed_player_update_page = admin_url + 'actions/embed_player_update.php';

    $('.confirm_update_embed_player').on("click", function () {
        let id  =  $(this).data('id');
        $.ajax({
            url: embed_player_update_page,
            type: "post",
            dataType: 'json',
            data: {
                mode: 'update'
                , id_video_embed : id
                , id_fontawesome_icon: $('#input_id_fontawesome_icon-' + id).val()
                , title: $('#input_title-' + id).val()
                , html: $('#input_html-' + id).val()
                , order: $('#input_order-' + id).val()
            },
            success: function (response) {
                $('#icon_' + id + ' span.fa').removeClass().addClass('fa').addClass('fa-' + response.data.icon);
                $('#icon_' + id + ' span.text-icon').html(response.data.icon);
                $('#title_' + id).html(response.data.title);
                $('#html_' + id).text(response.data.html);
                $('#order_' + id).html(response.data.social_network_link_order);

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
    $('.delete_embed_player').on("click", function () {
        var _this = $(this);
        if (confirm(lang['confirm_delete_embed_player'])) {
            var id  = _this.data('id');
            $.ajax({
                url: embed_player_update_page,
                type: "post",
                dataType: 'json',
                data: {
                    mode: 'delete'
                    ,id_video_embed : id
                },
                success: function (result) {
                    if(result.success === true){
                        $('#tr_' + id).fadeOut();
                    } else {
                        alert(lang['technical_error']);
                    }
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