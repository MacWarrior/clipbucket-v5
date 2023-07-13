DELETE FROM `{tbl_prefix}config` WHERE name IN('keep_original');

INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('keep_audio_tracks', '1'),
    ('keep_subtitles', '1');
