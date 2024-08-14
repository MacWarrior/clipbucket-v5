DROP TABLE IF EXISTS `{tbl_prefix}plugin_cb_social_networks`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'plugin_cb_social_networks_menu',
        'plugin_cb_social_networks_subtitle'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
    'plugin_cb_social_networks_menu',
    'plugin_cb_social_networks_subtitle'
);
