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
        self::generateTranslation('action_logs', [
            'fr' => 'Journaux d\'activité',
            'en' => 'Action logs'
        ]);

        self::generateTranslation('show_x_logs_entries', [
            'fr' => 'Afficher %s lignes de journaux',
            'en' => 'Showing %s logs entries'
        ]);

        self::generateTranslation('show_log_for_x_type', [
            'fr' => 'pour %s',
            'en' => 'for %s'
        ]);

        self::generateTranslation('login_only', [
            'fr' => 'Connexions uniquement',
            'en' => 'Logins only'
        ]);

        self::generateTranslation('signup_only', [
            'fr' => 'Inscriptions uniquement',
            'en' => 'Signups only'
        ]);

        self::generateTranslation('upload_video_only', [
            'fr' => 'Téléversements de vidéo uniquement',
            'en' => 'Video uploads only'
        ]);

        self::generateTranslation('clean_all', [
            'fr' => 'Tout effacer',
            'en' => 'Clean all'
        ]);

        self::generateTranslation('filter', [
            'fr' => 'Filtrer',
            'en' => 'Filter'
        ]);

        self::generateTranslation('actions', [
            'fr' => 'Actions',
            'en' => 'Actions'
        ]);

        self::generateTranslation('log_id', [
            'fr' => 'Identifiant de la ligne',
            'en' => 'Log ID'
        ]);

        self::generateTranslation('user_email', [
            'fr'=>'Email de l\'utilisateur',
            'en'=>'User email'
        ]);

        self::generateTranslation('action_performed', [
            'fr'=>'Activité effectuée',
            'en'=>'Action performed'
        ]);

        self::generateTranslation('action_time', [
            'fr'=>'Date d\'activité',
            'en'=>'Action time'
        ]);

        self::generateTranslation('confirm_clean_all_logs', [
            'fr'=>'Voulez-vous vraiment effacer tous les journaux ?',
            'en'=>'Do you really want to clean all logs ?'
        ]);

        $sql = 'UPDATE `{tbl_prefix}action_log` SET `action_type` = \'upload_video\' WHERE `action_type` LIKE \'Uploaded a video\'';
        self::query($sql);
    }
}
