<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00147 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('DROP TABLE ' . tbl('video_files'),
            [
                'table'  => 'video_files'
            ]
        );

        $sql = 'UPDATE ' . tbl('video') . ' SET `duration` = CAST(`duration` AS DECIMAL);';
        self::query($sql);

        self::alterTable('ALTER TABLE ' . tbl('video') . ' MODIFY COLUMN `duration` INT(20) NOT NULL DEFAULT 0;', [
            'table' => 'video',
            'column' => 'duration'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('video') . ' MODIFY COLUMN `video_version` varchar(8) NOT NULL DEFAULT \'5.5.1\';', [
            'table' => 'video',
            'column' => 'video_version'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('video') . ' MODIFY COLUMN `thumbs_version` varchar(8) NOT NULL DEFAULT \'5.5.1\';', [
            'table' => 'video',
            'column' => 'thumbs_version'
        ]);
    }
}
