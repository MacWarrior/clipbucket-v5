function headerFooter()
{
    var headerheight = "";
    var footerheight = "";
    var cont_height = "";
    var cont_height_new = "";
    cont_height = $("#container").height();
    headerheight = $("#header").outerHeight();
    footerheight = $("#footer").outerHeight();
    cont_height_new = cont_height - (headerheight + footerheight);
    $("#container").css('padding-top',headerheight+'px');
    $("#container").css('padding-bottom',footerheight+'px');

    $(".account-container, .page-error").css('height',cont_height_new+'px');
}

function shortKeys()
{
    $(document).keypress(function (e)
    {
        var key = e.which;
        if  ($('#query,textarea,#name,#email').is(":focus")) {
            // typing in field so shutup
        } else {
            if (pageNow == 'index')
            {
                if(key === 70 && e.shiftKey)  // shift + f = featured load more
                {
                    $('#featured_load_more').trigger("click");
                }

                if(key === 82 && e.shiftKey)  // shift + r = recent load more
                {
                    $('#recent_load_more').trigger("click");
                }
            } else if (pageNow == 'watch_video') {
                if(key === 70 && e.shiftKey)  // shift + f = featured load more
                {
                    $('.icon-plusrounded').trigger("click");
                    $('#addfav').trigger("click");
                }
                if(key === 82 && e.shiftKey)  // shift + r
                {
                    $('.icon-flag').trigger("click");
                }

                if(key === 84 && e.shiftKey)  // shift + t
                {
                    $('#comment_box').focus().select();
                }

                if(key === 69 && e.shiftKey)  // shift + e
                {
                    $('.icon-share').trigger("click");
                }
            }

            if(key === 83 && e.shiftKey)  // shift + s = search something
            {
                $('#query').focus().select();
            }

            if(key === 86 && e.shiftKey)  // shift + v = videos page
            {
                window.location.href = "/videos";
            }

            if(key === 80 && e.shiftKey)  // shift + p = photos page
            {
                window.location.href = "/photos";
            }

            if(key === 67 && e.shiftKey)  // shift + c = collections page
            {
                window.location.href = "/collections";
            }

            if(key === 85 && e.shiftKey)  // shift + u = channel page
            {
                window.location.href = "/channels";
            }
        }

    });
}

var flag = 0;
function responsiveFixes()
{
    var WinWidth = $(window).width();
    //console.log(WinWidth);
    var SearchHtml = $("#header .menu-holder .user_menu").html();
    var navseach = $('#header .navbar-header');
    var menuLinks = $("#header .menu-holder");

    if (WinWidth <992)
    {
        var length1 = navseach.find('.user_menu').length;
        if(length1==0)
        {
            $(navseach).append('<div class="col btn-holder user_menu text-right logged-out">'+SearchHtml+"</div>");
        }
        $('.menu-holder').find('.user_menu').remove();
    } else {
        var searchBtns = navseach.find('.user_menu').html();
        var length2 = menuLinks.find('.user_menu').length;

        if(length2==0)
        {
            menuLinks.append('<div class="col btn-holder user_menu text-right logged-out">'+searchBtns+"</div>");
        }
        navseach.find('.user_menu').remove();

    }
    if( WinWidth <1280 )
    {
        $(".btn-newacc .big").hide();
        $(".btn-newacc .little").show();
    } else {
        $(".btn-newacc .big").show();
        $(".btn-newacc .little").hide();
    }

    if(userid)
    {
        $(".user_menu").addClass('logged-in');
        $(".user_menu").removeClass('logged-out');
    } else {
        $(".user_menu").removeClass('logged-in');
        $(".user_menu").addClass('logged-out');
    }

    if( WinWidth <768 )
    {
        var length3 = $('.menu-holder').find('.newuser-links').length;
        if(length3==0)
        {
            var rightLinkHtml = $('.navbar-right').html();
            $('.menu-holder').prepend("<ul class='newuser-links'>"+rightLinkHtml+"</ul>");
            $('.navbar-right').remove();
        }
    }
    else{
        var length4 = $('.user_menu').find('.right-menu').length;
        if(length4==0)
        {
            var newLinkHtml = $('.newuser-links').html();
            $('.user_menu').append("<ul class='nav navbar-nav navbar-right right-menu'>"+newLinkHtml+"</ul>");
            $('.newuser-links').remove();
        }
    }
}

// automatically scrolls to new loaded videos
function thakkiLoading(yawnTo) {
    $("html, body").stop();
    $("html, body").animate({ scrollTop: yawnTo}, 1900, "swing");
}

function preLoadingBlock(){
    //two videos in a row
    var ftthumbWidth = $('.featured-videos .thumb-video').width();
    var	ftthumbHeight = ftthumbWidth * (10/16);
    $(".featured-videos .thumb-video").css('height', ftthumbHeight+'px');
    //three videos in a row
    var thumbWidth = $('.videos .thumb-video').width();
    var	thumbHeight = thumbWidth * (10/16);
    $(".videos .thumb-video").css('height', thumbHeight+'px');
}
function loginHeight(){
    var loginHeight = $("#login_form").outerHeight();
    loginHeight = loginHeight - 40;
    $(".account-holder .side-box").css('height', loginHeight+'px');
}

let listenerModernThumbVideo = function(event) {
    if(event.target.tagName !== 'IMG' ) {
        return ;
    }
    document.location.href = this.getAttribute('data-href');
}

let AddingListenerModernThumbVideo = function(){
    /** catch clic on new thumb video */
    document.querySelectorAll('.thumb-video:not(.cd-popup-trigger)').forEach(function(elem){
        elem.removeEventListener('click', listenerModernThumbVideo);
        elem.addEventListener('click', listenerModernThumbVideo);
    })
}

let listenerModernThumbVideoPopinView = function(event) {

    if(event.target.tagName !== 'IMG' ) {
        return ;
    }

    $('.cd-popup').addClass('is-visible');
    let videoid = this.getAttribute('data-videoid');
    _cb.getModalVideo(videoid)
}

let AddingListenerModernThumbVideoPopinView = function(){
    /** catch clic on new thumb video */
    document.querySelectorAll('.thumb-video.cd-popup-trigger').forEach(function(elem){
        elem.removeEventListener('click', listenerModernThumbVideoPopinView);
        elem.addEventListener('click', listenerModernThumbVideoPopinView);
    })
}

$(document).ready(function()
{
    //footer at bottom
    headerFooter();
    if(userid)
    {
        $(".user_menu").addClass('logged-in');
        $(".user_menu").removeClass('logged-out');
    } else{
        $(".user_menu").removeClass('logged-in');
        $(".user_menu").addClass('logged-out');
    }
    responsiveFixes();

    $(".navbar-sm-login-links a").click(function(){
        $("body").removeClass('sideactive');
    });

    var havechild = $('.adbox-holder').children().length;

    if (havechild == 0){
        $('.adbox-holder').hide();
    }

    $(".btn-search-toggle").click(function() {
        $(".navbar-header").toggleClass('show-search');
    });
    loginHeight();

    AddingListenerModernThumbVideo();
    AddingListenerModernThumbVideoPopinView();
});


function homePageVideos(qlist_items)
{
    console.log("Greetings Adventurers ! Having a look under the hood ? Happy sneaking buddy ! Drop us an email for any questions : contact+clipbucket@oxygenz.fr")
    $('#container').on("click","#recent_load_more, #featured_load_more",function()
    {
        var loadLink = '/ajax/home.php',
            main_object = $(this),
            sendType = 'post',
            dataType = 'html',
            loadType = $(main_object).attr('loadtype'),
            loadMode = $(main_object).attr('loadmode'),
            loadLimit = $(main_object).attr('loadlimit'),
            moreRecent = true,
            moreFeatured = true,
            featuredFound = '',
            featuredShown = $('#featured_vid_sec .item-video, #featured_vid_sec .slider-video-container').length,
            recentShown = $('#recent_vids_sec .item-video, #recent_vids_sec .slider-video-container').length,
            totalFeaturedVids = $('#container').find('.total_videos_featured').first().text(),
            totalRecentVids = $('#container').find('.total_videos_recent').first().text();
        first_launch = true;

        if( totalFeaturedVids != '' || totalRecentVids != '' )
        {
            if(totalFeaturedVids == '')
                totalFeaturedVids = 0;
            if(totalRecentVids == '')
                totalRecentVids = 0;
            var gotMoreFeatured = parseInt(totalFeaturedVids) - parseInt(featuredShown);
            var gotMoreRecent = parseInt(totalRecentVids) - parseInt(recentShown);

            first_launch = false;
        } else {
            var gotMoreFeatured = 2;
            var gotMoreRecent = 3;

            first_launch = true;
        }

        if (gotMoreFeatured > 2) {
            featuredFound = 2;
        } else {
            moreFeatured = false;
            featuredFound = gotMoreFeatured;
        }

        if (gotMoreRecent > 3) {
            recentFound = 3;
        } else {
            moreRecent = false;
            recentFound = gotMoreRecent;
        }

        var current_displayed, wanted;
        if( loadMode == 'featured' )
        {
            current_displayed = featuredShown;
            wanted = featuredFound;
        } else {
            current_displayed = recentShown;
            wanted = recentFound;
        }

        $.ajax({
            url: loadLink,
            type: sendType,
            dataType: dataType,
            data: {
                "load_type":loadType,
                "load_mode":loadMode,
                'current_displayed':current_displayed,
                'wanted':wanted,
                'first_launch':first_launch
            },

            beforeSend: function()
            {
                // setting a timeout
                $(main_object).attr('disabled','disabled');
                $(main_object).text("Loading...");
                if (loadType != 'count')
                {
                    if (loadMode == 'featured')
                    {
                        for (var i = 0; i < featuredFound; i++) {
                            $(document).find('#featured_pre').append('<div class="item-video col-lg-6 col-md-6 col-sm-6 col-xs-12"><div style="height:200px;" class="thumb-video background-masker clearfix"></div></div>');
                        }
                        var currWidth = $(window).width();
                        if (!first_launch && currWidth > 767) {
                            thakkiLoading($('.featAppending').last().offset().top);
                        }
                    } else {
                        for (var i = 0; i < recentFound; i++) {
                            $(document).find('#recent_pre').append('<div class="item-video col-lg-4 col-md-4 col-sm-4 col-xs-6"><div class="thumb-video background-masker clearfix"></div><div class="loadingInfo video-info relative clearfix"><div class="background-masker heading clearfix"></div><div class="background-masker paragraph clearfix"></div><div class="background-masker clearfix views-date"></div></div></div>');
                        }
                        preLoadingBlock();
                        var currWidth = $(window).width();
                        if (!first_launch && currWidth > 767) {
                            thakkiLoading($('#recent_pre').last().offset().top);
                        }
                    }
                }
            },

            success: function(data)
            {
                try {
                    var json = jQuery.parseJSON(data);
                    if(json.notice) {
                        if(!first_launch) {
                            _cb.throwHeadMsg('warning', json.notice, 3000,true);
                        } else {
                            $(main_object).remove();
                            if (loadMode == 'featured') {
                                $('#featured_load_more').hide();
                                $('#featured_pre').hide();
                                $("#featured_vid_sec").html('<span class="well well-info btn-block">'+langCo+'</span>');
                            } else if (loadMode == 'recent') {
                                $('#recent_load_more').remove();
                                $('#recent_pre').remove();
                                $("#recent_vids_sec").html('<span class="well well-info btn-block">'+noRecent+'</span>');
                            }
                        }
                        return true;
                    }
                    if(json.error) {
                        _cb.throwHeadMsg('error', json.error, 3000,true);
                        return true;
                    }
                }

                catch(err) {
                    $(main_object).removeAttr('disabled');
                    $(main_object).text(loadMoreLang);
                    if (loadType == 'video') {
                        if (loadMode == 'recent') {
                            $('#recent_load_more').remove();
                            $('#recent_pre').html('');
                            $(data).appendTo('#recent_vids_sec').fadeIn('slow');

                            recentShown = $('#recent_vids_sec .item-video, #recent_vids_sec .slider-video-container').length;
                            totalRecentVids = $('#container').find('.total_videos_recent').first().text();
                            gotMoreRecent = parseInt(totalRecentVids) - parseInt(recentShown);

                            if (gotMoreRecent > 0) {
                                $(document).find('#recent-loadmore').append('<div class="clearfix text-center"><button id="recent_load_more" class="btn btn-loadmore" loadtype="video" loadmode="recent" title="'+loadMoreLang+'">'+loadMoreLang+'</button></div>');
                            }
                        } else {
                            $('#featured_load_more').remove();
                            $('#featured_pre').html('');
                            $(data).appendTo('#featured_vid_sec').fadeIn('slow');

                            featuredShown = $('#featured_vid_sec .item-video, #featured_vid_sec .slider-video-container').length;
                            totalFeaturedVids = $('#container').find('.total_videos_featured').first().text();
                            gotMoreFeatured = parseInt(totalFeaturedVids) - parseInt(featuredShown);

                            if (gotMoreFeatured > 0) {
                                $(document).find('#featured-loadmore').append('<div class="clearfix text-center"><button id="featured_load_more" class="btn btn-loadmore" loadtype="video" loadmode="featured" title="'+loadMoreLang+'">'+loadMoreLang+'</button></div>');
                            }
                        }
                    }
                    $('#container').find('.total_videos_recent').hide();
                    $('#container').find('.total_videos_featured').hide();
                }
                AddingListenerModernThumbVideo();
                AddingListenerModernThumbVideoPopinView();
            }
        });
    });
    // trigger clicks on doc load to get
    // initial videos
    $(document).ready(function(){
        $('#featured_load_more').trigger("click");
        $('#featured_load_more').hide();
        $('#recent_load_more').trigger("click");
        $('#recent_load_more').hide();
    });
}
//on resize functions
$(window).resize(function(){
    headerFooter();
    preLoadingBlock();
    responsiveFixes();
    loginHeight();
});
//shortKeys();