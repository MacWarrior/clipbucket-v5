# Google Analytics 4 for ClipBucket V5

**Version:** 1.1.2  
**Author:** ZakHao

Optional Google Analytics 4 integration for ClipBucket V5. The plugin adds GA4 page-view tracking and video engagement tracking for ClipBucket V5's HTML5/Video.js player without modifying ClipBucket core templates.

## Features

- Configure the GA4 Measurement ID from the ClipBucket Admin Area.
- Enable or disable tracking without editing site templates.
- Automatic GA4 page-view tracking.
- Video start and resume tracking.
- Video pause tracking.
- Video progress tracking at 10%, 25%, 50%, 75%, and 90%.
- Video seek tracking.
- Video completion tracking.
- Video metadata parameters: `video_id`, `video_title`, `video_duration`, and `video_current_time`.
- Accumulated watch-time reporting for pause/progress/completion events.

## Video events

| Event | Description |
| --- | --- |
| `video_start` | First playback of a video |
| `video_resume` | Playback resumed after a pause |
| `video_pause` | Video paused |
| `video_progress` | First reach of 10%, 25%, 50%, 75%, or 90% |
| `video_seek` | User seeks to another position |
| `video_complete` | Video playback reaches the end |

## Installation

1. Copy the `Google_Analytics_4` directory to `upload/plugins/`.
2. Install the plugin from the ClipBucket Admin Area.
3. Open **Google Analytics 4** from the plugin configuration menu.
4. Enter your GA4 Measurement ID, for example `G-XXXXXXXXXX`.
5. Enable the plugin and save the settings.

The plugin stores its configuration in `plugin_ga4`. It does not require changes to `global_header.html`.

## Compatibility

Tested with ClipBucket V5.5.3 and its HTML5/Video.js player.

## Notes

The GA4 loader reads the configured Measurement ID server-side and generates the Google Analytics loader URL at runtime. This avoids relying on Smarty variable interpolation inside a header file registered through ClipBucket's plugin header mechanism.

## Author

ZakHao
