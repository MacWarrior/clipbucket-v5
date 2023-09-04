SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'collect_tag_hint');

DELETE FROM `{tbl_prefix}languages_translations` WHERE `id_language_key` = @id_language_key;
DELETE FROM `{tbl_prefix}languages_keys`WHERE `id_language_key` = @id_language_key;
