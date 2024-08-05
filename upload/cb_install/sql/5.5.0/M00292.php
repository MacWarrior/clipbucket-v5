<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00292 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'en\');';
        self::query($sql);
        $sql = 'SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = \'fr\');';
        self::query($sql);

        $sql = 'SET @language_key = \'option_enable_country\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Activer la sélection du pays\' WHERE id_language_key = @id_language_key AND language_id = @language_id_fra;';
        self::query($sql);

        $sql = 'SET @language_key = \'password\' COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        $sql = 'SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);';
        self::query($sql);
        $sql = 'UPDATE `{tbl_prefix}languages_translations` SET translation = \'Password\' WHERE id_language_key = @id_language_key AND language_id = @language_id_eng;';
        self::query($sql);

        self::generateTranslation('incorrect_url', [
            'en' => 'Incorrect URL',
            'fr' => 'URL incorrecte'
        ]);

        self::generateTranslation('option_enable_user_firstname_lastname', [
            'en' => 'Enable user firstname & lastname',
            'fr' => 'Activer le nom et prénom'
        ]);

        self::generateTranslation('option_enable_user_relation_status', [
            'en' => 'Enable user relation',
            'fr' => 'Activer le statut de relation'
        ]);

        self::generateTranslation('option_enable_user_postcode', [
            'en' => 'Enable user postal code',
            'fr' => 'Activer code postal'
        ]);

        self::generateTranslation('option_enable_user_hometown', [
            'en' => 'Enable user hometown',
            'fr' => 'Activer la ville natale'
        ]);

        self::generateTranslation('option_enable_user_city', [
            'en' => 'Enable user city',
            'fr' => 'Activer la ville'
        ]);

        self::generateTranslation('option_enable_user_education', [
            'en' => 'Enable user education',
            'fr' => 'Activer le niveau d\'étude'
        ]);

        self::generateTranslation('option_enable_user_schools', [
            'en' => 'Enable user schools',
            'fr' => 'Activer les écoles'
        ]);

        self::generateTranslation('option_enable_user_occupation', [
            'en' => 'Enable user occupation',
            'fr' => 'Activer la profession'
        ]);

        self::generateTranslation('option_enable_user_compagnies', [
            'en' => 'Enable user compagnies',
            'fr' => 'Activer les sociétés'
        ]);

        self::generateTranslation('option_enable_user_hobbies', [
            'en' => 'Enable user hobbies',
            'fr' => 'Activer les passions'
        ]);

        self::generateTranslation('option_enable_user_favorite_movies', [
            'en' => 'Enable user favorite movies',
            'fr' => 'Activer les films favoris'
        ]);

        self::generateTranslation('option_enable_user_favorite_music', [
            'en' => 'Enable user favorite music',
            'fr' => 'Activer la musique favorie'
        ]);

        self::generateTranslation('option_enable_user_favorite_books', [
            'en' => 'Enable user favorite books',
            'fr' => 'Activer les livres favoris'
        ]);

        self::generateTranslation('option_enable_user_website', [
            'en' => 'Enable user website',
            'fr' => 'Activer le site internet'
        ]);

        self::generateTranslation('option_enable_user_about', [
            'en' => 'Enable user about me',
            'fr' => 'Activer à propos de'
        ]);

        self::generateTranslation('option_enable_user_status', [
            'en' => 'Enable user status',
            'fr' => 'Activer le statut'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
        (\'enable_user_firstname_lastname\', \'yes\'),
        (\'enable_user_relation_status\', \'yes\'),
        (\'enable_user_postcode\', \'yes\'),
        (\'enable_user_hometown\', \'yes\'),
        (\'enable_user_city\', \'yes\'),
        (\'enable_user_education\', \'yes\'),
        (\'enable_user_schools\', \'yes\'),
        (\'enable_user_occupation\', \'yes\'),
        (\'enable_user_compagnies\', \'yes\'),
        (\'enable_user_hobbies\', \'yes\'),
        (\'enable_user_favorite_movies\', \'yes\'),
        (\'enable_user_favorite_music\', \'yes\'),
        (\'enable_user_favorite_books\', \'yes\'),
        (\'enable_user_website\', \'yes\'),
        (\'enable_user_about\', \'yes\'),
        (\'enable_user_status\', \'yes\');';
        self::query($sql);

        $sql = 'UPDATE `{tbl_prefix}config` SET `value` = \'\' WHERE `name` = \'min_age_reg\' AND `value` = \'0\';';
        self::query($sql);
    }
}