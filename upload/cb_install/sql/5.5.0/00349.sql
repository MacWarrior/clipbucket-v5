set @var=if((SELECT true FROM information_schema.TABLE_CONSTRAINTS WHERE
    CONSTRAINT_SCHEMA = DATABASE() AND
    TABLE_NAME        = '{tbl_prefix}video_subtitle' AND
    CONSTRAINT_NAME   = 'video_subtitle_ibfk_1' AND
    CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE {tbl_prefix}video_subtitle
            DROP FOREIGN KEY `video_subtitle_ibfk_1`','SELECT 1');
prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD CONSTRAINT `video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video`(`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

set @var=if((SELECT true FROM information_schema.TABLE_CONSTRAINTS WHERE
    CONSTRAINT_SCHEMA = DATABASE() AND
    TABLE_NAME        = '{tbl_prefix}languages_translations' AND
    CONSTRAINT_NAME   = 'languages_translations_ibfk_1' AND
    CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE {tbl_prefix}languages_translations
            DROP FOREIGN KEY `languages_translations_ibfk_1`','SELECT 1');
prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

set @var=if((SELECT true FROM information_schema.TABLE_CONSTRAINTS WHERE
    CONSTRAINT_SCHEMA = DATABASE() AND
    TABLE_NAME        = '{tbl_prefix}languages_translations' AND
    CONSTRAINT_NAME   = 'languages_translations_ibfk_2' AND
    CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE {tbl_prefix}languages_translations
            DROP FOREIGN KEY `languages_translations_ibfk_2`','SELECT 1');
prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

ALTER TABLE `{tbl_prefix}languages_translations`
    ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `languages_translations_ibfk_2` FOREIGN KEY (`id_language_key`) REFERENCES `{tbl_prefix}languages_keys` (`id_language_key`) ON DELETE NO ACTION ON UPDATE NO ACTION;

set @var=if((SELECT true FROM information_schema.TABLE_CONSTRAINTS WHERE
    CONSTRAINT_SCHEMA = DATABASE() AND
    TABLE_NAME        = '{tbl_prefix}video_thumbs' AND
    CONSTRAINT_NAME   = 'video_thumbs_ibfk_1' AND
    CONSTRAINT_TYPE   = 'FOREIGN KEY') = true,'ALTER TABLE {tbl_prefix}video_thumbs
            DROP FOREIGN KEY `video_thumbs_ibfk_1`','SELECT 1');
prepare stmt from @var;
execute stmt;
deallocate prepare stmt;

ALTER TABLE `{tbl_prefix}video_thumbs`
    ADD CONSTRAINT `video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;
