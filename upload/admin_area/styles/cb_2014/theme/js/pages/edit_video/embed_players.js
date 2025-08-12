$(document).ready(function() {
    $('#embed_player_hideshow').on('click', function (e) {
        e.preventDefault();
        $('#form_add_embed_player').slideDown();
        $(this).fadeOut();
    });
    $('#embed_player_cancel').on('click', function (e) {
        e.preventDefault();
        $('#form_add_embed_player').slideUp();
        $('#embed_player_hideshow').fadeIn();
    });

    var embed_player_update_page = admin_url + 'actions/embed_player_update.php';
    function initEmbedPlayerActions(){
        $('.edit_embed_player').off('click').on("click", function () {
            let id = $(this).data('id');
            $('.input-' + id).show();
            $('#ok-' + id).show();
            $('#remove-' + id).show();
            $('.edit-' + id).hide();
            $('#delete-' + id).hide();
            $('#edit-' + id).hide();
        });

        $('.cancel_embed_player').off('click').on("click", function () {
            let id = $(this).data('id');
            $('.input-' + id).hide();
            $('#ok-' + id).hide();
            $('#remove-' + id).hide();
            $('.edit-' + id).show();
            $('#delete-' + id).show();
            $('#edit-' + id).show();
        });

        $('.confirm_update_embed_player').off('click').on("click", function () {
            let id = $(this).data('id');
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

        $('.delete_embed_player').off('click').on("click", function () {
            if( !confirm(lang['confirm_delete_embed_player']) ) {
                return;
            }

            let id = $(this).data('id');
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
                        let $tr = $('#tr_' + id);

                        $tr.fadeOut(function () {
                            let tbody = $tr.closest('tbody');

                            let visibleDataRows = tbody.children('tr').filter(function () {
                                let row = $(this);
                                if (row.find('th').length){
                                    return false;
                                }
                                if (row.find('.empty_table').length){
                                    return false;
                                }
                                return row.is(':visible');
                            });

                            if (visibleDataRows.length === 0) {
                                tbody.find('.empty_table').closest('tr').fadeIn();
                            }
                        });
                    } else {
                        alert(lang['technical_error']);
                    }
                }
            });
        });
    }

    $('#embed_player_validate').on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: embed_player_update_page,
            type: "post",
            dataType: 'json',
            data: {
                mode: 'create'
                , videoid: videoid
                , id_fontawesome_icon: $('#new_embed_player_id_fontawesome_icon').val()
                , title: $('#new_embed_player_title').val()
                , html: $('#new_embed_player_html').val()
                , order: $('#new_embed_player_order').val()
            },
            success: function (response) {
                if(response.success === true){
                    $('#form_add_embed_player').slideUp();
                    $('#embed_player_hideshow').fadeIn();

                    $('#new_embed_player_id_fontawesome_icon').val(1);
                    $('#new_embed_player_title').val('');
                    $('#new_embed_player_html').val('');
                    $('#new_embed_player_order').val('');

                    let newRow = $(response.data.html).hide();
                    $('#embed_player table tbody').append(newRow);
                    let newIconSelects = newRow.find('.icon_select');
                    newIconSelects.each(function () {
                        $(this).select2({
                            templateSelection: select2_format_icon,
                            templateResult: select2_format_icon,
                            allowHtml: true
                        });
                    });

                    if( $('.empty_table') && $('.empty_table').closest('tr').is(':visible') ){
                        $('.empty_table').closest('tr').fadeOut(function () {
                            newRow.fadeIn();
                        });
                    } else {
                        newRow.fadeIn();
                    }

                    initEmbedPlayerActions();
                } else {
                    $('.page-content').prepend(response.msg);
                }

            }
        });
    });

    initEmbedPlayerActions();

    $('.icon_select').select2({
        templateSelection: select2_format_icon,
        templateResult: select2_format_icon,
        allowHtml: true
    });
});

function select2_format_icon (icon) {
    return $('<span><i class="fa fa-' + icon.text + '"></i> ' + icon.text + '</span>');
}