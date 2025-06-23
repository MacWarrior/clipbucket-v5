<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('confirm_delete_user_level', [
            'fr' => 'Voulez-vous vraiment supprimer ce niveau d\'utilisateur ?',
            'en' => 'Are you sure you want to delete this user level ?'
        ]);
        self::generateTranslation('enable_public_video_page', [
            'fr' => 'Activer la page de vidéos publiques',
            'en' => 'Enable public video page'
        ]);
        self::generateTranslation('enable_public_video_page_tips', [
            'fr' => 'Sépare les vidéos publiques dans une page dédiée',
            'en' => 'Separate public video to a dedicated page'
        ]);

        self::generateConfig('enable_public_video_page', 'no');

        self::generatePermission(1, 'allow_public_video_page', 'allow_public_video_page_desc', [
            1 => 'no',
            2 => 'no',
            3 => 'no',
            4 => 'yes',
            5 => 'yes',
            6 => 'no'
        ]);

        self::generatePermission(4, 'default_homepage', 'default_homepage_desc', [
            1 => 'homepage',
            2 => 'homepage',
            3 => 'homepage',
            4 => 'homepage',
            5 => 'homepage',
            6 => 'homepage'
        ]);

        self::generateTranslation('public_videos', [
            'fr' => 'Vidéos publiques',
            'en' => 'Public videos'
        ]);
        self::generateTranslation('level_del_sucess', [
            'fr' => 'Le niveau d\'utilisateur a bien été supprimé, tous les utilisateurs de ce niveau ont été transféré vers %s'
        ]);
        self::generateTranslation('default_homepage', [
            'fr' => 'Page d\'accueil par défaut',
            'en' => 'Default homepage'
        ]);
        self::generateTranslation('default_homepage_desc', [
            'fr' => 'Défini la page sur laquelle est redirigé l\'utilisateur à la connexion et au clique sur le logo',
            'en' => 'Set the page where user is redirect on login and click on logo'
        ]);
        self::generateTranslation('homepage', [
            'fr' => 'Page d\'accueil',
            'en' => 'Homepage'
        ]);
        self::generateTranslation('allow_public_video_page', [
            'fr' => 'Autoriser la page de vidéos publiques',
            'en' => 'Enable public video'
        ]);
        self::generateTranslation('allow_public_video_page_desc', [
            'fr' => 'L\'utilisateur peut voir la page de vidéo publique',
            'en' => 'Allow user to view public videos page'
        ]);
        self::generateTranslation('userlevel_cannot_be_default', [
            'fr' => 'Ce niveau d\'utilisateur ne peut être mis par défaut',
            'en' => 'This user level cannot be set as default'
        ]);
        self::generateTranslation('default_userlevel_cannot_be_disabled', [
            'fr' => 'Le niveau d\'utilisateur par défaut ne peut être désactivé',
            'en' => 'Default user level cannot be disabled'
        ]);
        self::generateTranslation('userlevel_cannot_be_disabled', [
            'fr' => 'Ce niveau d\'utilisateur ne peut être désactivé',
            'en' => 'This user level cannot be disabled'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('user_levels') . ' CHANGE `user_level_is_default` `user_level_is_origin` ENUM(\'yes\',\'no\') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT \'no\';', [
            'table'  => 'user_levels',
            'column' => 'user_level_is_default'
        ], [
            'table'  => 'user_levels',
            'column' => 'user_level_is_origin'
        ]);

        self::alterTable('ALTER TABLE ' . tbl('user_levels') . ' ADD COLUMN user_level_is_default ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'no\'', [
            'table' => 'user_levels'
        ], [
            'table'  => 'user_levels',
            'column' => 'user_level_is_default'
        ]);

        self::query('UPDATE ' . tbl('user_levels') . ' SET user_level_is_default = true WHERE user_level_id = 2');
    }
}
