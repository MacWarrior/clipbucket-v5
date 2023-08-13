ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN IF EXISTS `remote_play_url`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'plugin_cb_link_video_remote_play',
        'plugin_cb_link_video_invalid_duration',
        'plugin_cb_link_video_form_head',
        'plugin_cb_link_video_input_url',
        'plugin_cb_link_video_input_url_example',
        'plugin_cb_link_video_checking',
        'plugin_cb_link_video_invalid_step',
        'plugin_cb_link_video_invalid_url',
        'plugin_cb_link_video_invalid_extension',
        'plugin_cb_link_video_website_not_responding',
        'plugin_cb_link_video_url_not_working',
        'plugin_cb_link_video_not_valid_video',
        'plugin_cb_link_video_saving',
        'plugin_cb_link_video_saving_error',
        'plugin_cb_link_video_video_saved'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
    'plugin_cb_link_video_remote_play',
    'plugin_cb_link_video_invalid_duration',
    'plugin_cb_link_video_form_head',
    'plugin_cb_link_video_input_url',
    'plugin_cb_link_video_input_url_example',
    'plugin_cb_link_video_checking',
    'plugin_cb_link_video_invalid_step',
    'plugin_cb_link_video_invalid_url',
    'plugin_cb_link_video_invalid_extension',
    'plugin_cb_link_video_website_not_responding',
    'plugin_cb_link_video_url_not_working',
    'plugin_cb_link_video_not_valid_video',
    'plugin_cb_link_video_saving',
    'plugin_cb_link_video_saving_error',
    'plugin_cb_link_video_video_saved'
);
