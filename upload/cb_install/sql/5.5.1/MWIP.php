<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('user_levels_permissions') . '  ADD COLUMN `allow_photo_upload` ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'yes\'',
            [
                'table'  => 'user_levels_permissions'
            ], [
                'table'  => 'user_levels_permissions',
                'column' => 'allow_photo_upload'
            ]
        );

        self::generateTranslation('allow_photo_upload', [
            'fr'=>'Autorise le téléversement de photo',
            'en'=>'Allow photo upload'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}user_permissions` (`permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) 
            VALUES ( 2, \'Allow Photo Upload\', \'allow_photo_upload\', \'Allow user to upload photos\', \'yes\')';
        self::query($sql);
    }
}
