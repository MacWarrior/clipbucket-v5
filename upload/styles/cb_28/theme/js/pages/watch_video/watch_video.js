var cookieToSave, commentDataCheck;
var link_tags = true;
/*Cookie based comments backup end*/


/*Playlist load more end*/

var aspect_ratio = 1.77778

$(document).ready(function () {

    var $cb_player = $("#cb_player");

    cookieToSave = 'comment_data_u' + userid + "v" + current_video
        commentDataCheck = $.cookie(cookieToSave);

    if (commentDataCheck !== null) {
        $('#comment_box').val(commentDataCheck);
    }

    $('#ShareUsers').on("keyup", function () {
        console.log('treztr');
        if ($('#ShareUsers').val() === "")
            return;

        var typed = $(this).val();
        $.ajax({
            url: '/ajax.php',
            type: 'post',
            dataType: 'html',
            data: {
                "mode": 'user_suggest',
                "typed": typed
            },
            beforeSend: function () {
            },

            success: function (data) {
                $('#suggested_users').html('');
                var jsoned = $.parseJSON(data);
                $(jsoned.matching_users).each(function (index, element) {
                    $('#suggested_users').append("<option label='" + element + "' value='" + element + "'>");
                });
            }
        });
    });


    getAllComments('v', videoid, last_commented, 1, comments_count, object_type);

    $cb_player.height($cb_player.width() / aspect_ratio);

    var videoInfo = $("#videoDescription").text();
    var newInfo = videoInfo.replace(/(((https?:\/\/)|([\s\t]))(www.)?([a-z0-9]+)\.[a-z]+)/g, '<a href="$1">$1</a>');
    $("#videoDescription").html(newInfo);

    $("#reportVideo").on({
        click: function (e) {
            e.preventDefault();
            $("#flag_item").show();
        }
    });

    $("#subscribeUser").on({
        click: function (e) {
            e.preventDefault();
            _cb.subscribeToChannelNew(userid, 'subscribe_user');
        }
    });
    var adHtml = $('.ad-holder').html();
    if (adHtml < 1) {
        $('.ad-holder').remove();
    }


    /*Playlist load more start*/
    $('#playlist-pull').on("click", function () {
        var __this = $(this);
        loadHit = $(this).attr('dataHit');
        loadLimit = $(this).attr('dataLimit');
        playlist = $(this).attr('dataList');

        $.ajax({
            url: '/ajax/watch.php',
            type: 'post',
            dataType: 'html',
            data: {
                "mode": 'playlistMore',
                "loadHit": loadHit,
                "loadLimit": loadLimit,
                "playlist": playlist
            },
            beforeSend: function () {
                $(__this).text(lang_loading);
            },

            success: function (data) {
                var loaded = loadLimit * loadHit;
                if (playlist_total <= loaded) {
                    $(__this).remove();
                } else {
                    $(__this).text(lang_load_more);
                }
                if (data == 'none') {
                    $('#playlist-pull').remove();
                }
                $(data).appendTo('#playlist_items').fadeIn('slow');
                $('#playlist-pull').attr('dataHit', parseInt(loadHit) + 1);
            }
        });
    });

    $('#comment_box').on('keyup', function () {
        var comment_data = $('#comment_box').val();
        set_cookie_secure(cookieToSave, comment_data);
    });

    $('#add_comment_button').on("click", function () {
        set_cookie_secure(cookieToSave, null);
    });



/*    labels.on('mouseup', function (e) {
        switch (e.which)
        {
            // Left Click.
            case 1:
                //Ctrl+Click
                if (e.ctrlKey) {
                    window.open(url);
                } else {
                    // Standard LeftClick behaviour.
                    window.location.href = url;
                }
                break;

            // Middle click.
            case 2:
                e.preventDefault();
                window.open(url);
                return false;
                break;
            // Default behaviour for right click.
        }
        return true;
    });*/

});

var resizePlayer = _cb.debounce(function () {
    $cb_player.height($cb_player.width() / aspect_ratio);
}, 500, false);

$(window).resize(resizePlayer);