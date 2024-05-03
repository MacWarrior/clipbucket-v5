<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00187 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` DROP `plugin_license_type`', [
            'table' => 'plugins',
            'column' =>'plugin_license_type'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` DROP `plugin_license_key`', [
            'table' => 'plugins',
            'column' =>'plugin_license_key'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}plugins` DROP `plugin_license_code`', [
            'table' => 'plugins',
            'column' =>'plugin_license_code'
        ]);
    }
}