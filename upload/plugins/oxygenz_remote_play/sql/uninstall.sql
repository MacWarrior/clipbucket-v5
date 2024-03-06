ALTER TABLE `{tbl_prefix}video`
    DROP COLUMN `remote_play_url`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'plugin_oxygenz_remote_play_remote_play',
        'plugin_oxygenz_remote_play_invalid_duration',
        'plugin_oxygenz_remote_play_form_head',
        'plugin_oxygenz_remote_play_input_url',
        'plugin_oxygenz_remote_play_input_url_example',
        'plugin_oxygenz_remote_play_checking',
        'plugin_oxygenz_remote_play_invalid_step',
        'plugin_oxygenz_remote_play_invalid_url',
        'plugin_oxygenz_remote_play_invalid_extension',
        'plugin_oxygenz_remote_play_website_not_responding',
        'plugin_oxygenz_remote_play_url_not_working',
        'plugin_oxygenz_remote_play_not_valid_video',
        'plugin_oxygenz_remote_play_saving',
        'plugin_oxygenz_remote_play_saving_error',
        'plugin_oxygenz_remote_play_video_saved'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
    'plugin_oxygenz_remote_play_remote_play',
    'plugin_oxygenz_remote_play_invalid_duration',
    'plugin_oxygenz_remote_play_form_head',
    'plugin_oxygenz_remote_play_input_url',
    'plugin_oxygenz_remote_play_input_url_example',
    'plugin_oxygenz_remote_play_checking',
    'plugin_oxygenz_remote_play_invalid_step',
    'plugin_oxygenz_remote_play_invalid_url',
    'plugin_oxygenz_remote_play_invalid_extension',
    'plugin_oxygenz_remote_play_website_not_responding',
    'plugin_oxygenz_remote_play_url_not_working',
    'plugin_oxygenz_remote_play_not_valid_video',
    'plugin_oxygenz_remote_play_saving',
    'plugin_oxygenz_remote_play_saving_error',
    'plugin_oxygenz_remote_play_video_saved'
);
