let collectionVideoRequest = null;
let collectionVideoTrigger = null;

function resizeCollectionVideoPreview() {
    const preview = $('#collection-video-preview');
    const content = preview.find('.collection-video-content');
    const holder = content.find('.player-holder');
    if (preview.prop('hidden') || !holder.length) {
        return;
    }
    const video = content.find('video')[0];
    const dimensions = (holder[0].style.aspectRatio || '16 / 9').split('/').map(Number);
    const ratio = video && video.videoWidth && video.videoHeight
        ? video.videoWidth / video.videoHeight
        : dimensions[0] / (dimensions[1] || 1);
    const width = Math.min(content.width(), content.height() * ratio);
    holder.css({width: width + 'px', height: width / ratio + 'px', maxHeight: '100%'});
}

function closeCollectionVideoPreview() {
    const preview = $('#collection-video-preview');
    if (collectionVideoRequest) {
        collectionVideoRequest.abort();
        collectionVideoRequest = null;
    }
    preview.find('video').each(function () {
        const player = typeof videojs === 'function' ? videojs.getPlayer(this.id) : null;
        if (player) {
            player.dispose();
        } else {
            this.pause();
        }
    });
    preview.find('.collection-video-content').empty();
    preview.prop('hidden', true);
    if (collectionVideoTrigger) {
        collectionVideoTrigger.focus();
    }
}

function openCollectionVideoPreview(trigger) {
    closeCollectionVideoPreview();
    collectionVideoTrigger = trigger;
    const preview = $('#collection-video-preview');
    const content = preview.find('.collection-video-content');
    preview.prop('hidden', false).trigger('focus');
    content.attr('aria-busy', 'true');
    collectionVideoRequest = $.ajax({
        url: baseurl + 'actions/commonAjax.php',
        type: 'POST',
        dataType: 'json',
        data: {mode: 'get_video', videoid: trigger.getAttribute('data-videoid')},
        success: function (data) {
            if (!data.success) {
                content.text(data.message || $('#collection-items-modal').data('error'));
                return;
            }
            content.html(data.video);
            const holder = content.find('.player-holder');
            if (holder.length && !holder[0].style.aspectRatio) {
                holder.css('aspect-ratio', '16 / 9');
            }
            const video = content.find('video')[0];
            resizeCollectionVideoPreview();
            if (video) {
                const player = typeof videojs === 'function' ? videojs.getPlayer(video.id) : null;
                if (player) {
                    player.fluid(false);
                    player.fill(true);
                }
                const play = function () {
                    if (video.videoWidth && video.videoHeight) {
                        holder.css('aspect-ratio', video.videoWidth + ' / ' + video.videoHeight);
                    }
                    resizeCollectionVideoPreview();
                    const promise = video.play();
                    if (promise) {
                        promise.catch(function () {});
                    }
                };
                if (video.readyState > 0) {
                    play();
                } else {
                    video.addEventListener('loadedmetadata', play, {once: true});
                }
            }
        },
        error: function (xhr, status) {
            if (status !== 'abort') {
                content.text($('#collection-items-modal').data('error'));
            }
        },
        complete: function () {
            collectionVideoRequest = null;
            content.attr('aria-busy', 'false');
        }
    });
}

$(function () {
    const preview = $('#collection-video-preview');
    $(window).on('resize', resizeCollectionVideoPreview);
    preview.on('click', function (event) {
        if (event.target === this || $(event.target).is('.collection-video-content') || $(event.target).closest('.collection-video-close').length) {
            event.preventDefault();
            event.stopPropagation();
            closeCollectionVideoPreview();
        }
    });
    preview.on('keydown', function (event) {
        if (event.which === 27) {
            event.stopPropagation();
            if (!document.fullscreenElement && !preview.find('.vjs-fullscreen').length) {
                event.preventDefault();
                closeCollectionVideoPreview();
            }
        }
    });
    $('#collection-items-modal').on('hidden.bs.modal', closeCollectionVideoPreview);
});
