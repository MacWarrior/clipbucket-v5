DROP TABLE IF EXISTS `{tbl_prefix}plugin_cb_global_announcement`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'plugin_cb_global_announcement_menu',
        'plugin_cb_global_announcement_subtitle',
        'plugin_cb_global_announcement_edit',
        'plugin_cb_global_announcement_updated'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
    'plugin_cb_global_announcement_menu',
    'plugin_cb_global_announcement_subtitle',
    'plugin_cb_global_announcement_edit',
    'plugin_cb_global_announcement_updated'
);
