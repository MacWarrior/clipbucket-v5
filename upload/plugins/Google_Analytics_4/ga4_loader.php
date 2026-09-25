<?php
/*
 * ClipBucket GA4 runtime loader
 * Author: ZakHao
 * Version: 1.1.2
 *
 * This endpoint intentionally does not use Smarty. ClipBucket's add_header()
 * registers this header file directly, so Smarty variables in that file are
 * not rendered. The Measurement ID is read from the plugin table here and
 * emitted as JavaScript.
 */

header('Content-Type: application/javascript; charset=UTF-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

require_once dirname(__DIR__, 2) . '/includes/common.php';

$table = tbl('plugin_ga4');
$rows = Clipbucket_db::getInstance()->select($table, '*');
$config = $rows[0] ?? ['enabled' => 'no', 'measurement_id' => ''];

if (($config['enabled'] ?? 'no') !== 'yes') {
    echo "/* GA4 disabled */\n";
    exit;
}

$measurement_id = trim((string)($config['measurement_id'] ?? ''));
if (!preg_match('/^G-[A-Z0-9]+$/i', $measurement_id)) {
    echo "/* GA4 measurement ID is not configured */\n";
    exit;
}

$measurement_id_js = json_encode($measurement_id, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
(function () {
    'use strict';

    var measurementId = <?php echo $measurement_id_js; ?>;

    if (!measurementId || window.__cbGa4Loaded) return;
    window.__cbGa4Loaded = true;
    window.ga4MeasurementId = measurementId;

    window.dataLayer = window.dataLayer || [];
    window.gtag = window.gtag || function () { window.dataLayer.push(arguments); };
    window.gtag('js', new Date());
    window.gtag('config', measurementId);

    var script = document.createElement('script');
    script.async = true;
    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(measurementId);
    document.head.appendChild(script);

    function getVideoInfo(video) {
        var id = '';
        var match = (video.id || '').match(/^cb_video_js_(\d+)_html5_api$/);
        if (match) id = match[1];
        else if (video.id) id = video.id;

        var title = document.title || '';
        var titleNode = document.querySelector('.video-title, .video_title, h1.video-title, h1.video_title');
        if (titleNode && titleNode.textContent.trim()) title = titleNode.textContent.trim();

        return {
            video_id: id,
            video_title: title,
            video_duration: Number.isFinite(video.duration) ? Math.round(video.duration) : 0
        };
    }

    function sendVideoEvent(name, video, extra) {
        if (typeof window.gtag !== 'function') return;
        var info = getVideoInfo(video);
        var params = {
            video_id: info.video_id,
            video_title: info.video_title,
            video_duration: info.video_duration,
            video_current_time: Math.round(video.currentTime || 0)
        };
        if (extra) {
            Object.keys(extra).forEach(function (key) { params[key] = extra[key]; });
        }
        window.gtag('event', name, params);
    }

    function initVideoTracking(video) {
        if (!video || video.dataset.ga4TrackingInitialized === '1') return;
        video.dataset.ga4TrackingInitialized = '1';

        var sentProgress = {};
        var started = false;
        var wasPlaying = false;
        var seeking = false;
        var seekFrom = 0;
        var watchTime = 0;
        var lastTick = 0;
        var progressMarks = [10, 25, 50, 75, 90];

        video.addEventListener('play', function () {
            if (!started) {
                started = true;
                sendVideoEvent('video_start', video);
            } else if (!wasPlaying) {
                sendVideoEvent('video_resume', video);
            }
            wasPlaying = true;
            lastTick = Date.now();
        });

        video.addEventListener('pause', function () {
            if (wasPlaying) {
                sendVideoEvent('video_pause', video, { video_watch_time: Math.round(watchTime) });
            }
            wasPlaying = false;
        });

        video.addEventListener('timeupdate', function () {
            var now = Date.now();
            if (wasPlaying && lastTick) {
                var delta = (now - lastTick) / 1000;
                if (delta > 0 && delta < 5) watchTime += delta;
            }
            lastTick = now;

            var duration = video.duration;
            if (!Number.isFinite(duration) || duration <= 0) return;
            var percent = (video.currentTime / duration) * 100;
            progressMarks.forEach(function (mark) {
                if (percent >= mark && !sentProgress[mark]) {
                    sentProgress[mark] = true;
                    sendVideoEvent('video_progress', video, {
                        video_percent: mark,
                        video_watch_time: Math.round(watchTime)
                    });
                }
            });
        });

        video.addEventListener('seeking', function () {
            if (!seeking) {
                seeking = true;
                seekFrom = video.currentTime || 0;
            }
        });

        video.addEventListener('seeked', function () {
            if (seeking) {
                var seekTo = video.currentTime || 0;
                sendVideoEvent('video_seek', video, {
                    video_seek_from: Math.round(seekFrom),
                    video_seek_to: Math.round(seekTo)
                });
                seeking = false;
            }
        });

        video.addEventListener('ended', function () {
            if (wasPlaying && lastTick) {
                var delta = (Date.now() - lastTick) / 1000;
                if (delta > 0 && delta < 5) watchTime += delta;
            }
            wasPlaying = false;
            sendVideoEvent('video_complete', video, {
                video_percent: 100,
                video_watch_time: Math.round(watchTime)
            });
        });
    }

    function scanVideos() {
        document.querySelectorAll('video.vjs-tech, video[id*="_html5_api"]').forEach(initVideoTracking);
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', scanVideos);
    else scanVideos();

    if (window.MutationObserver) {
        var observer = new MutationObserver(function () { scanVideos(); });
        observer.observe(document.documentElement, { childList: true, subtree: true });
    }
})();
