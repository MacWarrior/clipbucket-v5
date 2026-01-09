var cookieToSave, commentDataCheck;
var link_type = "videos";

$(function () {
    cookieToSave = 'comment_data_u' + userid + "v" + current_video;
    commentDataCheck = $.cookie(cookieToSave);
    if (commentDataCheck !== 'null') {
        $('#comment_box').val(commentDataCheck);
    }

    $('#ShareUsers').on("keyup", function () {
        if ($('#ShareUsers').val() === ""){
            return;
        }

        var typed = $(this).val();
        $.ajax({
            url: baseurl+'actions/ajax.php',
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

    if( $("#userCommentsList").length > 0 ){
        getAllComments('v', videoid, last_commented, 1, comments_count, object_type);
    }

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
            url: baseurl+'actions/watch.php',
            type: 'post',
            dataType: 'html',
            data: {
                "mode": 'playlistMore',
                "loadHit": loadHit,
                "loadLimit": loadLimit,
                "playlist": playlist
            },
            beforeSend: function () {
                $(__this).html(loading);
            },

            success: function (data) {
                var loaded = loadLimit * loadHit;
                if (playlist_total <= loaded) {
                    $(__this).remove();
                } else {
                    $(__this).html(loading);
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
    $("[id^=tags]").each(function(elem){
        init_readonly_tags(this.id, '#list_'+this.id);
    });

    $('.view_history').on('click', function (e) {
        var video_title = $('#title').val();
        getViewHistory(videoid, 1);
    });

    if (ids_to_check_progress.length > 0) {
        intervalId = setInterval(function () {
            $.post({
                url: baseurl+'actions/progress_video.php',
                dataType: 'json',
                data: {
                    ids: ids_to_check_progress,
                    output: 'watch_video'
                },
                success: function (response) {
                    var data = response.data;

                    data.videos.forEach(function (video) {
                        if (video.status.toLowerCase() === 'processing') {
                            //update %
                            var process_div = $('.processing[data-id="' + video.videoid + '"]');
                            //if process don't exist : get thumb + process div
                            if (process_div.length === 0) {
                                $('.player-holder').html(video.html);
                            } else {
                                process_div.find('span').html(video.percent + '%');
                            }
                        } else {
                            $('.player-holder').html(video.html);
                            let images = document.querySelectorAll("img[data-thumbs]")
                            listenerPreviewThumbs(images);
                        }
                    });

                    if (response.all_complete) {
                        clearInterval(intervalId);
                    }
                }
            })
        }, 60000);
    }

    $('.manage_favorite').on('click', function (e) {
        let button = $(this);
        if (button.hasClass('glyphicon-heart')) {
            button.removeClass('glyphicon-heart').html(_cb.loading_img);
            //remove fav
            _cb.remove_from_fav('video', videoid).then(function (data) {
                button.html('').addClass('glyphicon-heart-empty');
                button.attr('title', lang['remove_from_favorites']);
            });
        } else {
            button.removeClass('glyphicon-heart-empty').html(_cb.loading_img);
            _cb.add_to_favNew('video', videoid).then(function (data) {
                button.html('').addClass('glyphicon-heart');
                button.attr('title', lang['add_to_my_favorites']);
            })
        }
    });
});

function getViewHistory(video_id, page) {
    showSpinner();
    $.ajax({
        url: baseurl+"actions/video_view_history.php",
        type: "POST",
        data: {videoid: video_id, page: page },
        dataType: 'json',
        success: function (result) {
            hideSpinner();
            var modal = $('#myModal');
            modal.html(result['template']);
            modal.modal();
            $('.page-content').prepend(result['msg']);
        }
    });
}

function pageViewHistory(page) {
    getViewHistory(videoid, page);
}
function showSpinner() {
    $('.taskHandler').show();
}
function hideSpinner() {
    $('.taskHandler').hide();
}
