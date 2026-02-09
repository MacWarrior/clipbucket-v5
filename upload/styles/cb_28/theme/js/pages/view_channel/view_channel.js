function userActivities(){
    if($(window).width() > 991) {
        let max_height;
        let content_height = $("#content").height();
        let screen_size = $("body").height();

        if( screen_size > content_height ){
            let content_position = $('#content').offset().top;
            max_height = screen_size - (content_position + 124);
        } else {
            max_height = content_height;
        }

        $(".user-activities").css({
            "max-height" : (max_height-43)+"px",
            "overflow-y" : "auto"
        });
    } else {
        $(".user-activities").css("max-height","auto");
    }
}

var link_type = "channels";

$(document).ready(function (){

    setTimeout(function(){
        userActivities();
    }, 200);

    $(window).resize(function() {
        userActivities();
    });

    $('.channel-tabs ul.nav-tabs li').click(function(){
        setTimeout(function(){
            userActivities();
        }, 200);
    });

    $('#subscribe_channel').on({
        click: function(e){
            e.preventDefault();
            _cb.subscribeToChannelNew(channelId,'subscribe_user');
        }
    });

    $('#myTab a, #reportTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#load_more_playlist').click(function() {
        var limit = $(this).attr("limit");
        var mode = 'load_more';
        var inner_mode = 'load_more_playlist';
        var append_id = 'load_more_channel_playlist';
        var attrb = $(this);
        var cat_id = $(this).attr("cat-id");
        var total = $(this).attr("total");
        load_more(limit,mode,inner_mode,append_id,attrb,cat_id,total);
    });

    $("#report-user").on("click",function(){
        $("#report-user-form").toggle();
    });

    $("#coverContainer").hover(function(e){
        $("#changeCover").show();
    }, function(e){
        $("#changeCover").hide();
    });

    $("#channelVoteUp, #channelVoteDown").one({
        click: function(e){
            var vote = "";
            var likes = parseInt($("#likes").text());
            var totalVotes = parseInt($("#totalVotes").text()) + 1;
            if(this.id === "channelVoteDown"){
                vote  = "no";
                likes = likes - 1;
            }else{
                vote = "yes";
                likes = likes + 1;
            }
            $.ajax({
                type: "POST",
                url: baseurl+"actions/vote_channel.php",
                data: { vote: vote, channelId : channelId},
                success: function(){
                    $("#likes").text(likes);
                    $("#totalVotes").text(totalVotes);
                }
            });
        }
    });

    $('#container').on("click","#more-view-channel",function(){
        loadHit = $(this).attr('dataHit');
        loadLimit = $(this).attr('dataLimit');
        totalShown = loadHit * loadLimit - loadLimit;
        if (totalVids - totalShown <= loadLimit) {
            loadMore = false;
        } else {
            loadMore = true;
        }

        nextHit = parseInt(loadHit) + 1;
        $.ajax({
            url: baseurl+"actions/view_channel.php",
            type: "post",
            dataType: "json",
            data: {
                "mode":'channelMore',
                "loadHit":loadHit,
                "totalVids":totalVids,
                "userid":channelId,
            },
            beforeSend: function() {
                $(document).find('#more-view-channel').text(loading + '...')
            },
            success: function(data) {
                $('#more-view-channel').parent().remove();
                if (data.videos.length >= 1) {
                    data.videos.forEach(function(elem){
                        $('#usr-vids').append('<div class="item-video col-lg-4 col-md-4 col-sm-6 col-xs-120" data-id="'+elem.id+'">'+elem.html+'</div>').fadeIn('slow');
                    });
                    if (loadMore === true) {
                        $('<div class="clearfix text-center"><button id="more-view-channel" class="btn btn-loadmore" dataLimit="'+loadLimit+'" dataHit="'+nextHit+'">'+loadMoreLang+'</button></div>').appendTo('.user_vids').fadeIn('slow');
                    }
                    $('#usr-vids').ready(()=> {
                        var scroll_point = $( ".item-video" ).last().offset().top;
                        thakkiLoading(scroll_point);
                    });
                    ids_to_check_progress = [...new Set([ids_to_check_progress, data.ids_to_check_progress].flat())];
                    if (ids_to_check_progress.length > 0) {
                        if (window['channel_video_interval'] !== undefined) {
                            clearInterval(window['channel_video_interval']);
                        }
                        progressVideoCheck(ids_to_check_progress, display_type, 'channel_video_interval');
                    }
                } else {
                    $('<div class="clearfix text-center"><button id="more-view-channel" class="btn btn-loadmore" disabled="disabled">Unable to fetch more</button></div>').appendTo('.user_vids').fadeIn('slow');
                }
            }
        });
    });

    $('#container').on("click","#more-channel-photos",function(){
        loadHit = $(this).attr('dataHit');
        loadLimit = $(this).attr('dataLimit');
        totalShown = loadHit * 9 - 9;
        if (totalPhotos - totalShown <= 9) {
            loadMore = false;
        } else {
            loadMore = true;
        }

        nextHit = parseInt(loadHit) + 1;
        $.ajax({
            url: baseurl+"actions/view_channel.php",
            type: "post",
            dataType: "html",
            data: {
                "mode":'channelMorePhotos',
                "loadHit":loadHit,
                "loadLimit":loadLimit,
                "userid":channelId,
            },
            beforeSend: function() {
                $(document).find('#more-channel-photos').text(loading + '...')
            },
            success: function(data) {
                $('#more-channel-photos').remove();
                if (data.length > 1) {
                    $(data).appendTo('#usr-photos').fadeIn('slow');
                    $('#usr-photos .clearfix').remove();
                    if (loadMore == true) {
                        $('<div class="clearfix text-center col-lg-12 col-md-12 col-sm-12 col-xs-12"><button id="more-channel-photos" class="btn btn-loadmore" dataLimit="'+loadLimit+'" dataHit="'+nextHit+'">'+loadMoreLang+'</button></div>').appendTo('.user_photos').fadeIn('slow');
                    }

                    let lastTop = $( ".photoAppending" ).last().offset().top,
                        currWidth = $(window).width();
                    let moveTo = lastTop + 240;
                    if (currWidth > 767) {
                        thakkiLoading(moveTo);
                    }
                } else {
                    $('<div class="clearfix text-center col-lg-12 col-md-12 col-sm-12 col-xs-12"><button id="more-view-channel" class="btn btn-loadmore" disabled="disabled">Unable to fetch more</button></div>').appendTo('.user_vids').fadeIn('slow');
                }
            }
        });
    });

    var uploader = new plupload.Uploader({
        browse_button: 'changeCover',
        runtimes : 'html5,silverlight,html4',
        url : baseurl+'edit_account.php?mode=update_cover',
        file_data_name : 'Filedata',
        chunk_size: chunk_upload ? max_upload_size : false,
        max_file_size : max_file_size,
        filters: {
            mime_types : [ { title : 'Image files', extensions : photo_extensions } ]
        },
        init: {
            BeforeUpload: function(uploader, file) {
                $.extend(uploader.settings.params, { unique_id : file.data.unique_id });
            }
        }
    });

    uploader.init();
    uploader.bind("FilesAdded", function(up, uploadedFiles){
        $(".cb-live-background").attr("src",baseurl+'images/loading.png');
        for(let i = 0; i < uploadedFiles.length; i++){
            uploadedFiles[i].data = [];
            uploadedFiles[i].data.unique_id = (Math.random() + 1).toString(36).substring(7);
        }
        up.start();
    });

    $(document).bind('chunkuploaded', function(event, result) {
        let response = $.parseJSON(result.response);
        let wanted_unique_id = result._options.params.unique_id;

        if (response.error) {
            uploader.abort(wanted_unique_id);
            alert(response.error);
        }
    });

    uploader.bind("FileUploaded", function(plupload, files, response){
        var data = $.parseJSON(response.response);

        if( data.error ){
            $('.cb-live-background').attr('src', baseurl+'images/background_default.jpg');
            alert(data.error);
        } else {
            if(data.status === true){
                $(".cb-live-background").attr("src",data.url);
            }else{
                $(".cb-live-background").attr("src",data.url);
                alert(data.msg);
            }
        }
    });

    uploader.bind("Error", function(plupload, error){
        alert(error.message);
    });

    if( $("#userCommentsList").length > 0 ){
        getAllComments(libelle_type_channel, channelId, '', 1, 0, '');
    }

    if( $('#profile_tags').length > 0 ){
        init_readonly_tags('profile_tags', '#list_tags_profile');
    }

    progressVideoCheck(ids_to_check_progress, display_type, 'channel_video_interval');
    eventFriendButton();
    _cb.listener_favorite_only_remove('photo');
});

function eventFriendButton() {
    $('.friend_button').on('click', function () {
        var mode = $(this).data('mode');
        var friend_id = $(this).data('friend-id');
        var to_sent = true;
        if (mode == 'unfriend') {
            to_sent = _cb.confirm_it(lang_confirm_unfriend);
        }
        if (to_sent) {
            $.ajax({
                url: baseurl + "actions/manage_contacts.php",
                type: "POST",
                data: {mode: mode, friend_id: friend_id},
                dataType: 'json',
                success: function (result) {
                    hideSpinner();
                    $('.friend-block').html(result.template);
                    $(result.msg).insertAfter('#header').fadeIn('slow').delay(3000).fadeOut();
                    if (!result.can_subscribe) {
                        $('.subs_' + friend_id).hide().prop('disabled', true);
                    }
                    $('#user_subscribers_' + friend_id).html(result.nb_subscribers);
                    eventFriendButton();
                },
            });
        }
    });
}
