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
        self::generateTranslation('editing', [
            'fr' => 'Edition',
            'en' => 'Editing'
        ]);

        self::generateTranslation('creation', [
            'fr' => 'Création',
            'en' => 'Creation'
        ]);

        self::generateTranslation('must_activate_storage_history', [
            'fr' => 'Vous devez activer l\'option "Activer l\'historique de stockage" pour éditer ce champs',
            'en' => 'You must activate option "Activate storage history" to edit this field'
        ]);


        self::generateTranslation('max_period_storage', [
            'fr' => 'Stockage maximum utilisé durant la période',
            'en' => 'Maximum storage during period'
        ]);

        self::generateTranslation('date_start', [
            'fr' => 'Date de début',
            'en' => 'Date start'
        ]);

        self::generateTranslation('date_end', [
            'fr' => 'Date de fin',
            'en' => 'Date end'
        ]);

        self::generateTranslation('price', [
            'fr' => 'Prix',
            'en' => 'Price'
        ]);

        self::generateTranslation('gb', [
            'fr' => 'Go',
            'en' => 'GB'
        ]);

        self::generateTranslation('per_gb', [
            'fr' => 'par Go',
            'en' => 'per GB'
        ]);

        self::generateTranslation('user_level_successfully_saved', [
            'fr' => 'Le niveau d\'utilisateur a été correctement enregistré',
            'en' => 'User level has been successfully saved'
        ]);

        self::generateTranslation('confirm_delete_user_level', [
            'fr' => 'Voulez-vous vraiment supprimer ce niveau d\'utilisateur ?',
            'en' => 'Are you sure you want to delete this user level ?'
        ]);

        self::generateTranslation('none', [
            'fr' => 'Aucun',
            'en' => 'None'
        ]);

        self::generateTranslation('never', [
            'fr' => 'Jamais',
            'en' => 'Never'
        ]);

        self::generateTranslation('status', [
            'fr' => 'Statut',
            'en' => 'Status'
        ]);

        self::generateTranslation('search_results_per_page', [
            'fr' => 'Résultats de recherche par page',
            'en' => 'Search results per page'
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

        self::generateTranslation('level_del_sucess_no_user', [
            'fr' => 'Le niveau d\'utilisateur a été supprimé',
            'en' => 'User level has been deleted'
        ]);

        self::generateTranslation('level_del_sucess', [
            'fr' => 'Le niveau d\'utilisateur a bien été supprimé, tous les utilisateurs de ce niveau ont été transféré vers %s'
        ]);

        self::generateTranslation('nb_users', [
            'fr' => 'Nombres d\'utilisateurs',
            'en' => 'Number of users'
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

        self::generateTranslation('allowed_emails', [
            'fr' => 'Emails autorisés',
            'en' => 'Allowed emails'
        ]);

        self::generateTranslation('allowed_emails_tips', [
            'fr' => 'Emails séparés par des virgules',
            'en' => 'Emails separated by commas'
        ]);

        self::generateTranslation('only_visible_eligible', [
            'fr' => 'Seulement visible si éligible',
            'en' => 'Only visible if eligible'
        ]);

        self::generateTranslation('email_is_not_valid', [
            'fr' => '%s n\'est pas un email valide',
            'en' => '%s is not a valid email'
        ]);
        self::generateTranslation('allow_public_video_page', [
            'fr' => 'Autoriser la page de vidéos publiques',
            'en' => 'Enable public video'
        ]);
        self::generateTranslation('allow_public_video_page_desc', [
            'fr' => 'L\'utilisateur peut voir la page de vidéo publique',
            'en' => 'Allow user to view public videos page'
        ]);

        self::generateTranslation('bouton_souscrire_abonnement', [
            'fr' => 'Souscrire',
            'en' => 'Subscription'
        ]);

        self::generateTranslation('plans_features_title', [
            'fr' => 'Détails',
            'en' => 'Details'
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

        self::query('UPDATE ' . tbl('user_levels') . ' SET user_level_is_default = true WHERE user_level_name LIKE \'Registered User\' ');

    }
}
