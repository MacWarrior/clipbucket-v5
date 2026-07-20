<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00160 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('report_and_stats', [
           'fr'=>'Rapports & Statistiques',
           'en'=>'Reports & Stats',
       ]);
       self::generateTranslation('other_reports', [
           'fr'=>'Autres rapports',
           'en'=>'Other reports',
       ]);
        self::generateTranslation('video_reports', [
            'fr'=>'Rapports de vidéos',
            'en'=>'Video reports',
        ]);
        self::generateTranslation('user_reports', [
            'fr'=>'Rapports des utilisateurs',
            'en'=>'User reports',
        ]);
        self::generateTranslation('todays_videos', [
            'fr'=>'Les vidéos du jour',
            'en'=>'Today\'s videos',
        ]);
        self::generateTranslation('todays_users', [
            'fr'=>'Les utilisateurs du jour',
            'en'=>'Today\'s users',
        ]);
        self::generateTranslation('videos_in_playlist', [
            'fr'=>'Vidéos dans des playlists',
            'en'=>'Videos in playlists',
        ]);
        self::generateTranslation('total_files_and_sizes', [
            'fr'=>'Total des fichiers et tailles',
            'en'=>'Total of files and sizes',
        ]);
        self::generateTranslation('folder_size', [
            'fr'=>'Taille du dossier',
            'en'=>'Folder size',
        ]);
        self::generateTranslation('total_thumbs', [
            'fr'=>'Nombre de vignettes',
            'en'=>'Total thumbnails',
        ]);
        self::generateTranslation('database_size', [
            'fr'=>'Taille de la base de données',
            'en'=>'Database size',
        ]);
        self::generateTranslation('user_avatars', [
            'fr'=>'Avatars des utilisateurs',
            'en'=>'Users avatars',
        ]);
        self::generateTranslation('user_backgrounds', [
            'fr'=>'Couverture des utilisateurs',
            'en'=>'Users backgrounds',
        ]);
        self::generateTranslation('category_thumbs', [
            'fr'=>'Vignette des catégories',
            'en'=>'Category thumbnails',
        ]);
        self::generateTranslation('original_video_files', [
            'fr'=>'Fichier originale des videos',
            'en'=>'Original video files',
        ]);

    }
}
