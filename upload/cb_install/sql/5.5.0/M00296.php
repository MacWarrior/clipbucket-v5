<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00296 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('collection_not_active', [
            'en' => 'Collection is not active',
            'fr' => 'La collection est désactivée'
        ]);

        self::generateTranslation('cant_pm_banned_user', [
            'fr' => 'Vous ne pouvez pas envoyer de message privé à %s'
        ]);

        self::generateTranslation('user_relat_status', [
            'en' => 'Relationship Status'
        ]);

        self::generateTranslation('usr_arr_open_relate', [
            'en' => 'Open Relationship',
            'fr' => 'Relation libre'
        ]);

        self::generateTranslation('already_spammed_comment', [
            'en' => 'You have already marked this comment as spam',
            'fr' => 'Vous avez déjà signaler ce commentaire en tant que spam'
        ]);

        self::generateTranslation('menu_home', [
            'en' => 'Home',
            'fr' => 'Accueil'
        ]);

        self::generateTranslation('no_own_commen_spam', [
            'en' => 'You cannot mark your own comment as spam',
            'fr' => 'Vous ne pouvez pas signaler votre propre commentaire en tant que spam'
        ]);

        self::generateTranslation('playlist_owner', [
            'en' => 'Owner',
            'fr' => 'Propriétaire'
        ]);

        self::generateTranslation('spam_comment_ok', [
            'en' => 'Comment has been marked as spam',
            'fr' => 'Le commentaire a été marqué comme spam'
        ]);
    }
}