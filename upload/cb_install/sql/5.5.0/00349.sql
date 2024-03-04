ALTER TABLE `{tbl_prefix}video_subtitle`
    DROP FOREIGN KEY `{tbl_prefix}video_subtitle_ibfk_1`;
ALTER TABLE `{tbl_prefix}video_subtitle`
    ADD CONSTRAINT `video_subtitle_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `cb_video`(`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `{tbl_prefix}languages_translations`
    DROP FOREIGN KEY `{tbl_prefix}languages_translations_ibfk_1`,
    DROP FOREIGN KEY `{tbl_prefix}languages_translations_ibfk_2`;

ALTER TABLE `{tbl_prefix}languages_translations`
    ADD CONSTRAINT `languages_translations_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `{tbl_prefix}languages` (`language_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `languages_translations_ibfk_2` FOREIGN KEY (`id_language_key`) REFERENCES `{tbl_prefix}languages_keys` (`id_language_key`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `{tbl_prefix}video_thumbs`
    DROP FOREIGN KEY `{tbl_prefix}video_thumbs_ibfk_1`;

ALTER TABLE `{tbl_prefix}video_thumbs`
    ADD CONSTRAINT `video_thumbs_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE RESTRICT ON UPDATE NO ACTION;
