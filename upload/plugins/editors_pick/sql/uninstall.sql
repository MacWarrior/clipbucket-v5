DROP TABLE IF EXISTS `{tbl_prefix}editors_picks`;
ALTER TABLE `{tbl_prefix}video` DROP `in_editor_pick`;

DELETE FROM `{tbl_prefix}languages_translations`
WHERE `id_language_key` IN(
    SELECT id_language_key FROM `{tbl_prefix}languages_keys`
    WHERE `language_key` IN(
        'plugin_editors_picks',
        'plugin_editors_picks_added',
        'plugin_editors_picks_removed',
        'plugin_editors_picks_removed_plural',
        'plugin_editors_picks_add_error',
        'plugin_editors_picks_add_to',
        'plugin_editors_picks_remove_from',
        'plugin_editors_picks_remove_confirm'
    )
);

DELETE FROM `{tbl_prefix}languages_keys`
WHERE `language_key` IN(
    'plugin_editors_picks',
    'plugin_editors_picks_added',
    'plugin_editors_picks_removed',
    'plugin_editors_picks_removed_plural',
    'plugin_editors_picks_add_error',
    'plugin_editors_picks_add_to',
    'plugin_editors_picks_remove_from',
    'plugin_editors_picks_remove_confirm'
);
