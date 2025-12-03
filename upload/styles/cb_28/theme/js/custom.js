function headerFooter()
{
    let headerheight = "";
    let footerheight = "";
    let cookie_banner = 0;
    let cont_height = "";
    let cont_height_new = "";

    cont_height = $("#container").height();
    headerheight = $("#header").outerHeight();
    footerheight = $("#footer").outerHeight();
    if( $("#cookie-banner").length > 0 ){
        cookie_banner = $("#cookie-banner").is(":visible") ? $("#cookie-banner").outerHeight() : 0;
    }

    cont_height_new = cont_height - (headerheight + footerheight + cookie_banner);
    $("#container").css('padding-top',headerheight+'px');
    $("#container").css('padding-bottom',(footerheight+cookie_banner)+'px');

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
                window.location.href = baseurl + "videos";
            }

            if(key === 80 && e.shiftKey)  // shift + p = photos page
            {
                window.location.href = baseurl + "photos";
            }

            if(key === 67 && e.shiftKey)  // shift + c = collections page
            {
                window.location.href = baseurl + "collections";
            }

            if(key === 85 && e.shiftKey)  // shift + u = channel page
            {
                window.location.href = baseurl + "channels";
            }
        }

    });
}

var flag = 0;
function responsiveFixes()
{
    var WinWidth = $(window).width();
    var SearchHtml = $("#header .menu-holder .user_menu").html();
    var navseach = $('#header .navbar-header');
    var menuLinks = $("#header .menu-holder");

    if (WinWidth <992) {
        var length1 = navseach.find('.user_menu').length;
        if(length1==0) {
            $(navseach).append('<div class="col btn-holder user_menu text-right logged-out">'+SearchHtml+"</div>");
        }
        $('.menu-holder').find('.user_menu').remove();
    } else {
        var searchBtns = navseach.find('.user_menu').html();
        var length2 = menuLinks.find('.user_menu').length;

        if(length2==0) {
            menuLinks.append('<div class="col btn-holder user_menu text-right logged-out">'+searchBtns+"</div>");
        }
        navseach.find('.user_menu').remove();

    }
    if( WinWidth <1280 ) {
        $(".btn-newacc .big").hide();
        $(".btn-newacc .little").show();
    } else {
        $(".btn-newacc .big").show();
        $(".btn-newacc .little").hide();
    }

    if(userid) {
        $(".user_menu").addClass('logged-in');
        $(".user_menu").removeClass('logged-out');
    } else {
        $(".user_menu").removeClass('logged-in');
        $(".user_menu").addClass('logged-out');
    }

    if( WinWidth <768 ) {
        var length3 = $('.menu-holder').find('.newuser-links').length;
        if(length3==0) {
            var rightLinkHtml = $('.navbar-right').html();
            $('.menu-holder').prepend("<div class='col'><nav class='main-links'><ul class='newuser-links'>"+rightLinkHtml+"</ul></nav></div>");
            $('.navbar-right').remove();
        }
    } else {
        var length4 = $('.user_menu').find('.right-menu').length;
        if(length4==0) {
            var newLinkHtml = $('.newuser-links').html();
            $('.user_menu').append("<ul class='nav navbar-nav navbar-right right-menu'>"+newLinkHtml+"</ul>");
            $('.newuser-links').remove();
        }
    }
    if ($('.menu-holder').find('.main-links>ul:not(.newuser-links)>li').length == 0) {
        $('i.icon-search').parent().removeClass('visible-xs').hide();
    } else {
        $('i.icon-search').parent().addClass('visible-xs').show();
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

function adaptRatioPlayer(){
    let div = document.querySelector('.player-holder');
    if(div === null){
        return;
    }

    let div_vieo = document.querySelector('.player-holder video');
    if(div_vieo === null){
        return;
    }

    const player = div.querySelector('.cb_player');
    if (player && player.style.aspectRatio && player.style.aspectRatio !== ''){
        return;
    }

    const ratio_window = window.innerWidth / window.innerHeight;
    const ratio_div = div_vieo.videoWidth / div_vieo.videoHeight;

    div.style.aspectRatio = ratio_div;

    if ( ratio_window > ratio_div) {
        div.classList.add('fix_ratio');
    } else {
        div.classList.remove('fix_ratio');
    }
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
    if(userid) {
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

    $(".btn-search-toggle").click(function() {
        $(".navbar-header").toggleClass('show-search');
    });
    loginHeight();

    AddingListenerModernThumbVideo();
    AddingListenerModernThumbVideoPopinView();

    window.addEventListener('resize', adaptRatioPlayer);

    $(".cbsearchtype a").on({
        click: function(e){
            e.preventDefault();
            let prent_li = $(this).parents();
            let theNewVal = $(this).attr('valNow');
            $('.type').val(theNewVal);
            $('.cbsearchtype li').removeClass('active');
            prent_li.addClass('active');
        }
    });

    $('.s-types').on("click", function(){
        let text = $(this).html();
        $('.search-type').html(text);
    });

    $('#cbsearch').on("click", function(e){
        e.preventDefault();
        let searchQuery = $('#query').val();
        let queryLen = searchQuery.length;
        if (queryLen <= 2) {
            let msg = lang_search_too_short;
            msg = msg.replace('%s', '<b>'+searchQuery+'</b>');
            _cb.throwHeadMsg('warning', msg, 3000, true);
        } else {
            $('.search-form').submit();
        }
    });

    const isDark = matchMedia('(prefers-color-scheme: dark)').matches;
    console.log(`%cGreetings Adventurers!` +
        `\n%cHaving a look under the hood? Happy sneaking buddy!🕵️‍♂️` +
        `\n%c📬 Drop us an email for any questions : contact+clipbucket@oxygenz.fr` +
        `\n%c🛠️ Check out the project on GitHub: https://github.com/MacWarrior/clipbucket-v5`,
        `font-size:18px; font-weight:bold; color:${isDark ? '#90ee90' : '#2e7d32'}`,
        `font-size:14px; color:${isDark ? '#ccc' : '#444'}`,
        `font-size:14px; font-style:italic; color:${isDark ? '#80d8ff' : '#1565c0'}`,
        `font-size:14px; color:${isDark ? '#ffeb3b' : '#f57c00'}; font-weight: bold;`
    );

    headerFooter();
});

function homePageVideos(qlist_items)
{
    $('#container').on("click","#recent_load_more, #featured_load_more",function()
    {
        var loadLink = baseurl+'actions/home.php',
            main_object = $(this),
            sendType = 'post',
            dataType = 'json',
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
                var json = data;
                if(json.notice) {
                    if(!first_launch) {
                        _cb.throwHeadMsg('warning', json.notice, 3000,true);
                        return true
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

                $(main_object).removeAttr('disabled');
                $(main_object).text(loadMoreLang);
                if (loadType == 'video') {
                    if (loadMode == 'recent') {
                        $('#recent_load_more').remove();
                        $('#recent_pre').html('');
                        $(json.html).appendTo('#recent_vids_sec').fadeIn('slow');

                        recentShown = $('#recent_vids_sec .item-video, #recent_vids_sec .slider-video-container').length;
                        totalRecentVids = $('#container').find('.total_videos_recent').first().text();
                        gotMoreRecent = parseInt(totalRecentVids) - parseInt(recentShown);

                        if (gotMoreRecent > 0) {
                            $(document).find('#recent-loadmore').append('<div class="clearfix text-center"><button id="recent_load_more" class="btn btn-loadmore" loadtype="video" loadmode="recent" title="'+loadMoreLang+'">'+loadMoreLang+'</button></div>');
                        }
                        ids_to_check_progress_recent = [...new Set([...ids_to_check_progress_recent, ...json.ids_to_check])]
                        progressVideoCheckHome(ids_to_check_progress_recent, 'home', 'intervalId_recent')
                    } else {
                        $('#featured_load_more').remove();
                        $('#featured_pre').html('');
                        $(json.html).appendTo('#featured_vid_sec').fadeIn('slow');

                        featuredShown = $('#featured_vid_sec .item-video, #featured_vid_sec .slider-video-container').length;
                        totalFeaturedVids = $('#container').find('.total_videos_featured').first().text();
                        gotMoreFeatured = parseInt(totalFeaturedVids) - parseInt(featuredShown);

                        if (gotMoreFeatured > 0) {
                            $(document).find('#featured-loadmore').append('<div class="clearfix text-center"><button id="featured_load_more" class="btn btn-loadmore" loadtype="video" loadmode="featured" title="'+loadMoreLang+'">'+loadMoreLang+'</button></div>');
                        }

                        ids_to_check_progress_featured = [...new Set([...ids_to_check_progress_featured, ...json.ids_to_check])]
                        progressVideoCheckHome(ids_to_check_progress_featured, 'home_featured', 'intervalId_featured' )
                    }
                }
                $('#container').find('.total_videos_recent').hide();
                $('#container').find('.total_videos_featured').hide();
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
    preLoadingBlock();
    responsiveFixes();
    loginHeight();
    headerFooter();
});

document.addEventListener("DOMContentLoaded", function () {
    /* Thumbs preview */
    let images = document.querySelectorAll("img[data-thumbs]");
    images.forEach(img => {
        let thumbnails;
        try {
            let thumbsData = img.getAttribute("data-thumbs");
            thumbnails = JSON.parse(thumbsData);
        } catch (error) {
            return;
        }
        if (!Array.isArray(thumbnails) || thumbnails.length === 0) return;
        let index = 0;
        let interval;
        let parent = img.closest("div");
        parent.addEventListener("mouseenter", function () {
            if( img.src ){
                img.dataset.originalSrc = img.src;
            }
            interval = setInterval(() => {
                index = (index + 1) % thumbnails.length;
                if (thumbnails[index]) {
                    img.src = thumbnails[index];
                }
            }, 500);
        });
        parent.addEventListener("mouseleave", function () {
            clearInterval(interval);
            if (img.dataset.originalSrc) {
                img.src = img.dataset.originalSrc;
            }
            index = 0;
        });
    });
    /* Thumbs preview */

    /* Theme switch */
    function postThemeSwitch(selected_theme){
        jQuery.post({
            'url':baseurl+'actions/switch_theme.php',
            'dataType':'json',
            'data': {
                theme: selected_theme,
                os: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
            },
            'success':function(data){
                let link = document.createElement("link");
                link.rel = "stylesheet";
                link.type = "text/css";
                link.href = data.url;
                document.head.appendChild(link);

                document.body.classList.add('theme_transition');
                if (data.theme === 'dark' ) {
                    document.documentElement.classList.remove('light');
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                }
                setTimeout(() => {
                    document.body.classList.remove('theme_transition');
                }, 1000);

                const event = new CustomEvent("postThemeSwitch", {
                    detail: {
                        theme: data.theme
                    }
                });
                document.dispatchEvent(event);
            }
        });

    }

    let buttons = document.querySelectorAll('.theme-switch button');
    buttons.forEach(button => {
        button.addEventListener('click', () => {
            if (button.classList.contains('active')) {
                return;
            }

            let current_active = document.querySelector('.theme-switch button.active');
            if (current_active) {
                current_active.classList.remove('active');
            }

            button.classList.add('active');

            postThemeSwitch(button.dataset.theme);
        });
    });

    let html = document.documentElement;
    if (html.classList.contains('auto')) {
        html.classList.remove('auto');

        postThemeSwitch('auto');
    }
    /* Theme switch */

    /* Language switch */
    document.querySelectorAll('.pick-lang').forEach(button => {
        button.addEventListener('click', () => {
            const lang_id = button.dataset.lang;
            const url = new URL(window.location.href);
            const params = url.searchParams;

            params.set('set_site_lang', lang_id);

            url.search = params.toString();
            window.location = url.toString();
        });
    });
    /* Language switch */
});

/* Cookie banner */
function updateCookieBannerPosition() {
    let banner = document.getElementById('cookie-banner');
    let footer = document.getElementById('footer');
    if (!banner || !footer) {
        return;
    }

    let footerRect = footer.getBoundingClientRect();
    let windowHeight = window.innerHeight || document.documentElement.clientHeight;

    if (footerRect.top < windowHeight) {
        banner.classList.remove('sticky');
        banner.classList.add('above-footer');
        let bannerHeight = banner.offsetHeight;
        banner.style.top = (footer.offsetTop - bannerHeight) + 'px';
        banner.style.bottom = '';
    } else {
        banner.classList.remove('above-footer');
        banner.classList.add('sticky');
        banner.style.top = '';
        banner.style.bottom = '0';
    }
}

function showCookieBanner() {
    if (typeof cookieConsent !== 'undefined' && !cookieConsent ) {
        let banner = document.getElementById('cookie-banner');
        if (banner) {
            banner.style.display = '';
            updateCookieBannerPosition();
        }
    }
}
function hideCookieBanner() {
    document.getElementById('cookie-banner').style.display = 'none';
}
function showCookieModal() {
    let modal = document.getElementById('cookieListModal');
    modal.classList.add('in');
    modal.style.display = 'block';
    if (!document.querySelector('.modal-backdrop')) {
        let backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade in';
        backdrop.onclick = closeCookieModal;
        document.body.appendChild(backdrop);
    }
    document.body.classList.add('modal-open');

    document.getElementById('refuse_all_optionnal').onclick = function() {
        let form = document.getElementById('cookie-preferences-form');
        let checkboxes = form.querySelectorAll('input[type="checkbox"]:not(:disabled)');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
        saveCookiePreferences();
    };

    document.getElementById('accept_all_cookies').onclick = function() {
        let form = document.getElementById('cookie-preferences-form');
        let checkboxes = form.querySelectorAll('input[type="checkbox"]:not(:disabled)');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
        saveCookiePreferences();
    };

    document.getElementById('save_cookie_preferences').onclick = function() {
        saveCookiePreferences();
    };
}
function closeCookieModal() {
    let modal = document.getElementById('cookieListModal');
    modal.classList.remove('in');
    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
    let backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.parentNode.removeChild(backdrop);
    }
}
function renderCookieList() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', baseurl+'actions/cookie_consent_get.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            try {
                let response = JSON.parse(xhr.responseText);
                if (response && response.template) {
                    document.getElementById('cookie-list-content').innerHTML = response.template;
                    showCookieModal();
                } else {
                    document.getElementById('cookie-list-content').innerHTML = '<div class="alert alert-danger">Erreur lors de la récupération du contenu.</div>';
                }
            } catch(e) {
                document.getElementById('cookie-list-content').innerHTML = '<div class="alert alert-danger">Réponse inattendue du serveur.</div>';
            }
        }
    };
    xhr.send();
}
function ajaxSetConsent(value, callback) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", baseurl+"actions/cookie_consent_set.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (typeof callback === 'function') {
                callback(xhr.responseText);
            }
        }
    };
    xhr.send("consent=" + encodeURIComponent(value));
}

function fade(element, type = 'in', duration = 400) {
    let opacityStart = (type === 'in') ? 0 : 1;
    let opacityEnd   = (type === 'in') ? 1 : 0;

    if (type === 'in') {
        element.style.opacity = opacityStart;
        element.style.display = '';
    }

    let startTime = null;
    function tick(now) {
        if (!startTime) startTime = now;
        let elapsed = now - startTime;
        let progress = Math.min(elapsed / duration, 1);

        let currentOpacity;
        if (type === 'in') {
            currentOpacity = opacityStart + (opacityEnd - opacityStart) * progress;
            element.style.opacity = currentOpacity;
            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                element.style.opacity = opacityEnd;
            }
        } else {
            currentOpacity = opacityStart - (opacityStart - opacityEnd) * progress;
            element.style.opacity = currentOpacity;
            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                element.style.opacity = opacityEnd;
                element.style.display = 'none';
            }
        }
    }
    requestAnimationFrame(tick);
}

function checkDisabledFeatured(data){
    for (let key in data) {
        if (Object.prototype.hasOwnProperty.call(data, key)) {
            let type_animation = data[key] === 0 ? 'out' : 'in';
            let elem, computedStyle, isVisible;
            switch (key) {
                case 'fast_qlist':
                    let elems = document.querySelectorAll('.cb_quickie');
                    elems.forEach(function(el) {
                        computedStyle = window.getComputedStyle(el);
                        isVisible = computedStyle.display !== 'none' && parseFloat(computedStyle.opacity) > 0;

                        if ((type_animation === 'in' && !isVisible) ||
                            (type_animation === 'out' && isVisible)) {
                            fade(el, type_animation, 1000);
                        }
                    });

                    let qlist_main = document.getElementById('qlist_main');
                    let qlistCount = document.getElementById('qlist_count');
                    if (qlist_main && qlistCount && qlistCount.textContent.trim() !== '' && qlistCount.textContent.trim() !== '0') {
                        computedStyle = window.getComputedStyle(qlist_main);
                        isVisible = computedStyle.display !== 'none' && parseFloat(computedStyle.opacity) > 0;

                        if ((type_animation === 'in' && !isVisible) ||
                            (type_animation === 'out' && isVisible)) {
                            fade(qlist_main, type_animation, 1000);
                        }
                    }
                    break;
                case 'user_theme':
                    elem = document.querySelector('.theme-switch');
                    break;
                case 'user_theme_os':
                    elem = document.querySelector('.theme-switch button[data-theme="auto"]');
                    break;
                case 'cb_lang':
                    elem = document.querySelector('.langdrop');
                    break;
            }

            if( elem ){
                computedStyle = window.getComputedStyle(elem);
                isVisible = computedStyle.display !== 'none' && parseFloat(computedStyle.opacity) > 0;

                if ((type_animation === 'in' && !isVisible) ||
                    (type_animation === 'out' && isVisible)) {
                    fade(elem, type_animation, 1000);
                }
            }
        }
    }
}

function saveCookiePreferences() {
    let form = document.getElementById('cookie-preferences-form');
    let data = {};
    let inputs = form.querySelectorAll('input[type="checkbox"]');
    inputs.forEach(function(input) {
        data[input.name] = input.checked ? 1 : 0;
    });
    ajaxSetConsent(JSON.stringify(data), function(response) {
        closeCookieModal();
        hideCookieBanner();
        checkDisabledFeatured(data);
    });
}

window.addEventListener('scroll', updateCookieBannerPosition);
window.addEventListener('resize', updateCookieBannerPosition);

document.addEventListener('DOMContentLoaded', function() {
    showCookieBanner();

    let cookieLinks = document.querySelectorAll('.show-cookie-list');
    if( cookieLinks.length > 0 ){
        for (let i = 0; i < cookieLinks.length; i++) {
            cookieLinks[i].onclick = function(e) {
                renderCookieList();
            };
        }
        document.getElementById('modal-close-btn').onclick = closeCookieModal;

        let acceptButtons = document.querySelectorAll('.accept-cookies');
        acceptButtons.forEach(function(btn) {
            btn.onclick = function() {
                ajaxSetConsent('all', function() {
                    closeCookieModal();
                    hideCookieBanner();
                });
            };
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                let modal = document.getElementById('cookieListModal');
                if (modal && window.getComputedStyle(modal).display !== 'none') {
                    closeCookieModal();
                }
            }
        });
    }
});
/* Cookie banner */