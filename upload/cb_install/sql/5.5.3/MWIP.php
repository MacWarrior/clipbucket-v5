<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `re_conv_status`', [
           'table' => 'video',
           'column' => 're_conv_status'
       ]);
       self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `flv`', [
           'table' => 'video',
           'column' => 'flv'
       ]);
       self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `flv_file_url`', [
           'table' => 'video',
           'column' => 'flv_file_url'
       ]);
    }
}
