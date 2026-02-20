let fullscreen = false;

function buildPhotoUrl(xhr, display) {
    var collectionId = xhr.collection_id,
        photo_key = xhr.photo_key,
        photo_title = xhr.photo_title,
        nonSeoUrl = baseurl + "view_item.php?item=" + photo_key + "&collection=" + collectionId,
        theSeoUrl = baseurl + "item/photos/" + collectionId + "/" + photo_key + "/" + photo_title,
        mainUrl = nonSeoUrl;

    if (seoUrls == 'yes' && display == 'aho') {
        mainUrl = theSeoUrl;
    } else if (display == 'aho') {
        mainUrl = nonSeoUrl;
    }

    return mainUrl;
}

function galleryDimension() {
    var galleryHeight = $("#gallery").height();
    $('#gallery .inner-holder').css("height", galleryHeight + "px");
    if ($('#gallery img').width() < $('#gallery img').height()) {
        $('#gallery img').addClass('tall_img');
    } else {
        $('#gallery img').removeClass('tall_img');
    }
}

function overlayDimension() {
    var screenHeight = $(window).height();
    $('#myNav .overlay-content').css("height", screenHeight + "px");
}

function refreshComments(data) {
    if ($("#userCommentsList").length > 0) {
        getAllComments('p', data.photo.photo_id, data.photo.photo_id.last_commented, 1, data.photo.photo_id.total_comments, lang['photo']);
    }
}

function nextPrevPhoto(button, beforeSend, success) {
    var check = $(button).data('check');
    if (check == "prev") {
        var pre_next = "prev";
    }
    if (check == "next") {
        var pre_next = "next";
    }
    data = {
        'photo_id': curr_photo.photo_id,
        'collection_id': curr_photo.collection_id,
        'direction': pre_next,
        'fullscreen': Number(fullscreen)
    }

    $.ajax({
        url: baseurl + 'actions/photo_display.php',
        type: "post",
        data: data,
        dataType: 'json',
        beforeSend: beforeSend,
        success: function (data) {
            if (data.success) {
                curr_photo = data.photo;
                srcFirst = data.original_thumb
                window.history.pushState("", "", buildPhotoUrl(data.photo, "aho"));
                if (fullscreen) {
                    $('#main').replaceWith(data.html);
                    refreshComments(data);
                    success(data);
                } else {
                    $('#main').fadeOut('0', function () {
                        $('#main').replaceWith(data.html);
                        $('#main').fadeIn('0').promise().done(function () {
                            refreshComments(data);
                            success(data);
                        });
                    })
                }
            } else {
                if (data.redirect != '') {
                    location.href = data.redirect;
                }
            }
        }
    });
}

// event which brings previous image from the collection
$(document).on("click", "#mainNextBtn,#mainPrevBtn", function () {
    fullscreen = false;
    nextPrevPhoto(this, function () {
        $('.photo-view').append(loader_black);
        $('#gallery').fadeTo("slow", 0.33);
        $('.view-photo').prop("disabled", true);
    }, function () {
        launchAfterLoad('#gallery img', galleryDimension);
    });
});

// Event which enlarge the image size in model.
$(document).on("click", ".en-large", function () {
    fullscreen = true;
    nextPrevPhoto(this, function () {
        $('.overlay-content').append(loader_white);
        $('.en-large').prop("disabled", true);
    }, function () {
        $('.en-large').prop("disabled", false);
        $("#gallery").fadeTo("normal", 0.99);
        launchAfterLoad('#gallery-exd', sample)
        launchAfterLoad('#gallery img', galleryDimension);
    });
});

$(document).on('keydown', function (event) {
    if ($('#myNav').hasClass('maximized')) {
        if (event.key == "ArrowLeft") {
            $(".en-large.view-photo-pre").trigger('click');
        } else if (event.key == "ArrowRight") {
            $(".en-large.view-photo-nxt").trigger('click');
        }
    } else {
        if (event.key == "ArrowLeft") {
            $("#mainPrevBtn").trigger('click');
        } else if (event.key == "ArrowRight") {
            $("#mainNextBtn").trigger('click');
        }
    }
})
$(document).ready(function () {
    galleryDimension();
});

$(window).resize(function () {
    galleryDimension();
    overlayDimension();
});

$(document).on("click", "#enlarge", function () {
    if ($(this).attr('disabled')) {
        return false;
    }
    $('body').addClass('image-zoom');
    $('#myNav').attr("style", "width:100%;left:0;");
    $('#myNav').addClass('maximized');
    $('#gallery-exd').attr("src", srcFirst);
    overlayDimension();
});

function sample() {
    var imgwd = $("#gallery-exd").width();
    var imght = $("#gallery-exd").height();
    if (imgwd < imght) {
        $("#gallery-exd").addClass('tallest');
    } else {
        $("#gallery-exd").removeClass('tallest');
    }
}


// On closing modal update image source..
$(document).on("click", "#btn-close", remove_enlarge);

$(document).on('keydown', function (e) {
    if (e.keyCode === 27) { // ESC
        remove_enlarge();
    }
});

function remove_enlarge() {
    $('body,#main').removeClass('image-zoom');
    $('#myNav').attr("style", "left:-100%;").removeClass('maximized');
}

$('.dropdown-menu li').on('click', function () {
    var searchQuery = $('input#query').val();
    if (searchQuery.length > 1) {
        $('#cbsearch').trigger('click');
    }
});

$(function () {
    _cb.listener_favorite('photo', curr_photo.photo_id);
    launchAfterLoad('#gallery-exd', sample);
});

function launchAfterLoad(selector, function_to_call) {
    $(selector).each(function () {
        if (this.complete && this.naturalWidth !== 0) {
            function_to_call();
        } else {
            $(this).on("load", function_to_call);
        }
    });
}