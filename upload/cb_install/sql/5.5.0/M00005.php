<?php
require_once DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00005 extends Migration
{
    /**
     * @throws Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
        (\'extract_audio_tracks\', \'1\');';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_audio_tracks` (
            `videoid` BIGINT(20) NOT NULL,
            `number` VARCHAR(2) NOT NULL,
            `title` VARCHAR(64) NOT NULL,
            `channels` TINYINT(4) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_audio_tracks` ADD UNIQUE KEY `videoid` (`videoid`,`number`);', [
            'table' => '{tbl_prefix}video_audio_tracks',
            'columns' => ['videoid', 'number']
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_audio_tracks` ADD CONSTRAINT `video_audio_tracks_ibfk_1` FOREIGN KEY (`videoid`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE CASCADE ON UPDATE CASCADE;', [
            'table' => '{tbl_prefix}video_audio_tracks',
            'column'=>'videoid',
            'constraint_name'=>'video_audio_tracks_ibfk_1',
            'contraint_type'=>'FOREIGN KEY'
        ]);
    }
}