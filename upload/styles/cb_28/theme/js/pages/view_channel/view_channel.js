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
            if(this.id == "channelVoteDown"){
                vote  = "no";
                likes = likes - 1;
            }else{
                vote = "yes";
                likes = likes + 1;
            }
            $.ajax({
                type: "POST",
                url: "/actions/vote_channel.php",
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
        totalShown = loadHit * 9 - 9;
        if (totalVids - totalShown <= 9) {
            loadMore = false;
        } else {
            loadMore = true;
        }

        nextHit = parseInt(loadHit) + 1;
        $.ajax({
            url: "/ajax/view_channel.php",
            type: "post",
            dataType: "html",
            data: {
                "mode":'channelMore',
                "loadHit":loadHit,
                "loadLimit":loadLimit,
                "totalVids":totalVids,
                "userid":channelId,
            },
            beforeSend: function() {
                $(document).find('#more-view-channel').text('Loading videos..')
            },
            success: function(data) {
                $('#more-view-channel').remove();
                if (data.length > 1) {
                    $(data).appendTo('#usr-vids').fadeIn('slow');
                    if (loadMore == true) {
                        $('<div class="clearfix text-center"><button id="more-view-channel" class="btn btn-loadmore" dataLimit="'+loadLimit+'" dataHit="'+nextHit+'">'+loadMoreLang+'</button></div>').appendTo('.user_vids').fadeIn('slow');
                    }
                    var moveTo = $( ".recentAppending" ).last().offset().top,
                        currWidth = $(window).width();
                    moveTo = moveTo - 630;
                    if (currWidth > 767) {
                        thakkiLoading(moveTo);
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
            url: "/ajax/view_channel.php",
            type: "post",
            dataType: "html",
            data: {
                "mode":'channelMorePhotos',
                "loadHit":loadHit,
                "loadLimit":loadLimit,
                "totalPhotos":totalPhotos,
                "userid":channelId,
            },
            beforeSend: function() {
                $(document).find('#more-channel-photos').text('Loading photos..')
            },
            success: function(data) {
                $('#more-channel-photos').remove();
                if (data.length > 1) {
                    $(data).appendTo('#usr-photos').fadeIn('slow');
                    if (loadMore == true) {
                        $('<div class="clearfix text-center"><button id="more-channel-photos" class="btn btn-loadmore" dataLimit="'+loadLimit+'" dataHit="'+nextHit+'">loadMoreLang</button></div>').appendTo('.user_photos').fadeIn('slow');
                    }

                    var moveTo = $( ".photoAppending" ).last().offset().top,
                        currWidth = $(window).width();
                    moveTo = moveTo + 240;
                    if (currWidth > 767) {
                        thakkiLoading(moveTo);
                    }
                } else {
                    $('<div class="clearfix text-center"><button id="more-view-channel" class="btn btn-loadmore" disabled="disabled">Unable to fetch more</button></div>').appendTo('.user_vids').fadeIn('slow');
                }
            }
        });
    });

    var uploader = new plupload.Uploader({
        browse_button: 'changeCover',
        runtimes : 'html5,flash,silverlight,html4',
        url : "/edit_account.php?mode=avatar_bg",
        file_data_name : "backgroundPhoto",
        filters: {
            mime_types : [
                { title : "Image files", extensions : extensions },
            ],
            max_file_size: "2mb",
            prevent_duplicates: false,
        }
    });
    window.uploader = uploader;
    uploader.init();
    uploader.bind("FilesAdded", function(up, uploadedFiles){
        $(".cb-live-background").attr("src",'/images/loading.png');
        up.start();
    });
    uploader.bind('UploadComplete', function(plupload, files, response){});

    uploader.bind("FileUploaded", function(plupload, files, response){
        var response = $.parseJSON(response.response);
        if(response.status == true){
            $(".cb-live-background").attr("src",response.url);
        }else{
            $(".cb-live-background").attr("src",response.url);
            alert(response.msg);
        }
    });

    uploader.bind("Error", function(plupload, error){
        alert(error.message);
    });

    getAllComments(libelle_type_channel, channelId, '', 1, 0, '');
});