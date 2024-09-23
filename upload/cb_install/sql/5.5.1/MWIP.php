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

        $sql_set = 'set @user_level_id = (SELECT user_level_id FROM ' . tbl('user_levels') . ' WHERE user_level_name = \'Guest\') ';
        self::query($sql_set);
        $sql = ' UPDATE ' . tbl('user_levels_permissions') .' SET `allow_photo_upload` = \'no\' WHERE user_level_id = @user_level_id';
        self::query($sql);
        self::generateTranslation('allow_photo_upload', [
            'fr'=>'Autorise le téléversement de photo',
            'en'=>'Allow photo upload'
        ]);

        self::query('UPDATE ' . tbl('user_levels') . ' SET user_level_is_default = \'no\' ');
        self::query('UPDATE ' . tbl('user_levels') . ' SET user_level_is_default = \'yes\' WHERE user_level_id = 2 ');

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}user_permissions` (`permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) 
            VALUES ( 2, \'Allow Photo Upload\', \'allow_photo_upload\', \'Allow user to upload photos\', \'yes\')';
        self::query($sql);
    }
}
