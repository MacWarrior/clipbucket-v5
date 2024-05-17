<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00149 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       $sql='  SET @enable_video_file_upload = (SELECT `value` FROM `{tbl_prefix}config` WHERE `name` = \'load_upload_form\');';
       self::query($sql);
       $sql=' SET @enable_video_remote_upload = (SELECT `value` FROM `{tbl_prefix}config` WHERE `name` = \'load_remote_upload_form\');';
       self::query($sql);
       $sql=' INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES (\'enable_video_file_upload\', @enable_video_file_upload), (\'enable_video_remote_upload\', @enable_video_remote_upload), (\'enable_photo_file_upload\', \'yes\');';
       self::query($sql);
       $sql=' DELETE FROM `{tbl_prefix}config` WHERE `name` IN (\'load_upload_form\',\'load_remote_upload_form\');';
       self::query($sql);
    }
}