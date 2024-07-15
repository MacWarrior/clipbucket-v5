<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00060 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}config` SET `name` = \'enable_comments_video\' WHERE `name` = \'display_video_comments\';';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}config` SET `name` = \'enable_comments_photo\' WHERE `name` = \'display_photo_comments\';';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}config` SET `name` = \'enable_comments_collection\' WHERE `name` = \'display_collection_comments\';';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}config` SET `name` = \'enable_comments_channel\' WHERE `name` = \'display_channel_comments\';';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` CHANGE `allow_comments` `allow_comments` ENUM(\'yes\',\'no\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'yes\';', [
            'table'  => 'user_profile',
            'column' => 'allow_comments'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}user_profile` CHANGE `allow_ratings` `allow_ratings` ENUM(\'yes\',\'no\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'yes\';', [
            'table'  => 'user_profile',
            'column' => 'allow_ratings'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}users` CHANGE `featured` `featured` ENUM(\'no\',\'yes\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'no\';', [
            'table'  => 'users',
            'column' => 'featured'
        ]);

        self::deleteTranslation('option_display_video_comments');
        self::deleteTranslation('option_display_photo_comments');
        self::deleteTranslation('display_collection_comments');
        self::deleteTranslation('enable_collection_comments');

        self::deleteConfig('video_comments');
        self::deleteConfig('photo_comments');

        self::generateTranslation('option_enable_comments_video', [
            'fr' => 'Activer les commentaires de vidéo',
            'en' => 'Enable videos comments'
        ]);
        self::generateTranslation('option_enable_comments_photo', [
            'fr' => 'Activer les commentaires de photo',
            'en' => 'Enable photo comments'
        ]);
        self::generateTranslation('option_enable_comments_collection', [
            'fr' => 'Activer les commentaires de collection',
            'en' => 'Enable collection comments'
        ]);
        self::generateTranslation('option_enable_comments_channel', [
            'fr' => 'Activer les commentaires de chaîne',
            'en' => 'Enable channel comments'
        ]);

    }
}