<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00142 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'video_age_verification\', \'yes\');';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD `age_required` INT NULL DEFAULT NULL;', [
            'table' => 'video'
        ], [
            'table' => 'video',
            'column' => 'age_required'
        ]);
    }
}