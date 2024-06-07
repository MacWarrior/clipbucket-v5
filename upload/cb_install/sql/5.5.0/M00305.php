<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00305 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` ADD COLUMN age_restriction INT DEFAULT NULL;', [
            'table' => 'photos'
        ], [
            'table' => 'photos',
            'column' => 'age_restriction'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN age_restriction INT DEFAULT NULL;', [
            'table' => 'video'
        ], [
            'table' => 'video',
            'column' => 'age_restriction'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config` (name, value) VALUES
        (\'enable_user_dob_edition\', \'yes\'),
        (\'enable_age_restriction\', \'yes\'),
        (\'enable_blur_restricted_content\', \'no\'),
        (\'enable_global_age_restriction\', \'no\'); ';
        self::query($sql);

        self::generateTranslation('age_restriction', [
            'en' => 'Age restriction',
            'fr' => 'Restriction d\'âge'
        ]);

        self::generateTranslation('info_age_restriction', [
            'en' => 'Set field empty for no restriction, else input minimum age to access',
            'fr' => 'Laisser le champs vide pour aucune restriction. Sinon mettez l\'âge minimum pour accéder au contenu'
        ]);

        self::generateTranslation('error_age_restriction', [
            'en' => 'You are not old enough to access this content',
            'fr' => 'Vous n\'avez pas l\'âge nécessaire pour accéder à ce contenu'
        ]);

        self::generateTranslation('access_forbidden_under_age', [
            'en' => 'Access prohibited under %s',
            'fr' => 'Accès interdit aux moins de %s ans'
        ]);

        self::generateTranslation('option_enable_age_restriction', [
            'en' => 'Enable age restriction on medias',
            'fr' => 'Activer la restriction d\'âge sur les médias'
        ]);

        self::generateTranslation('option_enable_user_dob_edition', [
            'en' => 'Allow date of birth edition',
            'fr' => 'Autoriser l\'édition de la date de naissance'
        ]);

        self::generateTranslation('user_dob_edition_disabled', [
            'en' => 'Date of birth edition is disabled',
            'fr' => 'L\'édition de la date de naissance est désactivée'
        ]);

        self::generateTranslation('option_enable_blur_restricted_content', [
            'en' => 'Blur restricted contents',
            'fr' => 'Flouter les contenus restreints'
        ]);

        self::generateTranslation('tips_enable_blur_restricted_content', [
            'en' => 'When enabled, restricted contents are visible but blurred ; when not, restricted contents are hidden',
            'fr' => 'Si activé, les contenus restreints sont visible mais floutés ; sinon, les contenus restreints sont masqués'
        ]);

        self::generateTranslation('enable_global_age_restriction', [
            'en' => 'Enable global age restriction pop-in',
            'fr' => 'Activer la pop-in de restriction d\'âge globale'
        ]);

        self::generateTranslation('error_age_restriction_save', [
            'en' => 'Minimal age required must be between 1 and 99',
            'fr' => 'L\'âge minimum requis doit être compris entre 1 et 99'
        ]);

        self::generateTranslation('age_verification', [
            'en' => 'Age verification',
            'fr' => 'Vérification d\'âge'
        ]);

        self::generateTranslation('age_verification_text', [
            'en' => 'This website contains age-restricted materials. By entering, you affirm that you are at least %s years of age.',
            'fr' => 'Ce site web contient du matériel avec des restrictions d\'âge. En vous connectant, vous affirmer que vous avez au moins %s ans.'
        ]);

        self::generateTranslation('disclaimer_older', [
            'en' => 'I am %s or older - Enter',
            'fr' => 'J\'ai %s ans ou plus - Entrer'
        ]);

        self::generateTranslation('disclaimer_return', [
            'en' => 'I am under %s - Exit',
            'fr' => 'J\'ai moins de %s ans - Sortir'
        ]);

        self::generateTranslation('tips_enable_global_age_restriction', [
            'en' => 'Based on minimum age for registration',
            'fr' => 'Basé sur l\'âge minimum d\'inscription'
        ]);

        self::generateTranslation('edition_min_age_request', [
            'en' => 'Age can\'t be under %s',
            'fr' => 'L\'âge ne peut être inférieur à %s ans'
        ]);

        $sql = 'SET @language_key = \'register_min_age_request\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations`
            SET `translation` = \'You must be at least %s year old to register\'
            WHERE `id_language_key` = @id_language_key AND `language_id` = @language_id_eng;';
        self::query($sql);
    }
}