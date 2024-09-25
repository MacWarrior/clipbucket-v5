<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00143 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('user_levels_permissions') . ' ADD COLUMN `allow_photo_upload` ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'yes\'',
            [
                'table'  => 'user_levels_permissions'
            ], [
                'table'  => 'user_levels_permissions',
                'column' => 'allow_photo_upload'
            ]
        );

        $sql = 'INSERT IGNORE INTO ' . tbl('user_permissions') .' (`permission_type`, `permission_name`, `permission_code`, `permission_desc`, `permission_default`) 
            VALUES (2, \'Allow Photo Upload\', \'allow_photo_upload\', \'Allow user to upload photos\', \'yes\')';
        self::query($sql);

        $sql = 'UPDATE ' . tbl('user_levels_permissions') .' SET `allow_photo_upload` = \'no\', `allow_video_upload` = \'no\', `allow_channel_bg` = \'no\', `allow_create_playlist` = \'no\', `private_msg_access` = \'no\', `edit_video` = \'no\', `enable_channel_page` = \'no\' WHERE user_level_id = 4';
        self::query($sql);

        $sql = 'UPDATE ' . tbl('user_levels') . ' SET user_level_is_default = \'yes\' WHERE user_level_id <= 6';
        self::query($sql);

        self::generateTranslation('allow_photo_upload', [
            'fr'=>'Autorise le téléversement de photo',
            'en'=>'Allow photo upload'
        ]);


    }
}
