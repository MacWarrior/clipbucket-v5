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
        self::generateTranslation('user_date_joined', [
            'fr' => 'Date d\'inscription',
            'en' => 'Joined date'
        ]);

        self::generateTranslation('user_date_last_login', [
            'fr' => 'Dernière connexion',
            'en' => 'Last login'
        ]);

        self::generateTranslation('user_date_last_active', [
            'fr' => 'Dernière activité',
            'en' => 'Last active'
        ]);

        self::generateTranslation('profile_views', [
            'fr' => 'Vues du profil',
            'en' => 'Profile views'
        ]);

        self::generateTranslation('user_total_videos', [
            'fr' => 'Nombre de vidéos',
            'en' => 'Total videos'
        ]);

        self::generateTranslation('user_video_watched', [
            'fr' => 'Nombre de vidéos vues',
            'en' => 'Videos watched'
        ]);

        self::generateTranslation('user_comments_made', [
            'fr'=>'Nombre de commentaires faits',
            'en'=>'Comments made'
        ]);

        self::generateTranslation('user_comments_received', [
            'fr'=>'Nombre de commentaire sur le profile',
            'en'=>'Comments received on profil'
        ]);

        self::generateTranslation('user_profile_rating', [
            'fr'=>'Note du profile',
            'en'=>'Profile rating'
        ]);

        self::generateTranslation('user_profile_rating_count', [
            'fr'=>'Nombre de notes',
            'en'=>'Rating count'
        ]);

        self::generateTranslation('ip', [
            'fr'=>'IP',
            'en'=>'IP'
        ]);

        self::generateTranslation('nb_users_are_online', [
            'fr'=>'%s utilisateurs en ligne',
            'en'=>'%s users are online'
        ]);

        self::generateTranslation('see_detail', [
            'fr'=>'Voir les détails',
            'en'=>'See details'
        ]);

        self::generateTranslation('kick', [
            'fr'=>'Expulser',
            'en'=>'Kick'
        ]);

        self::generateTranslation('kick_hint', [
            'fr'=>'Cela déconnectera de force l\'utilisateur',
            'en'=>'This will make user force logout'
        ]);

        self::generateTranslation('right_now', [
            'fr'=>'Actuellement',
            'en'=>'Right now'
        ]);

        self::generateTranslation('view_referer', [
            'fr'=>'Voir le référant',
            'en'=>'View referer'
        ]);

        self::generateTranslation('recent_activity_log', [
            'fr'=>'Journaux d\'activité récente',
            'en'=>'Recent activity log'
        ]);

        self::generateTranslation('view_online_users', [
            'fr'=>'Voir les utilisateurs en ligne',
            'en'=>'View online users'
        ]);
    }
}
