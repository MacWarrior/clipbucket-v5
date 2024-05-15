<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00169 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `id_tools_status`, `elements_total`, `elements_done`) VALUES
            (\'update_database_version_label\', \'update_database_version_description\', \'AdminTool::updateDataBaseVersion\', 1, NULL, NULL);';
        self::query($sql);

        self::generateTranslation('need_db_upgrade', [
            'en' => 'You have <b>%s</b> files to execute to upgrade your database. You can use this following link :  ',
            'fr' => 'Vous avez <b>%s</b> fichiers de mise à jour à exécuter. Pour cela vous pouvez utiliser le lien suivant : '
        ]);

        self::generateTranslation('db_up_to_date', [
            'en' => 'Your database is up to date',
            'fr' => 'Votre base de données est à jour'
        ]);

        self::generateTranslation('update_database_version_label', [
            'en' => 'Update your database to current version',
            'fr' => 'Mise à jour de la base de données à la version actuelle'
        ]);

        self::generateTranslation('update_database_version_description', [
            'en' => 'Execute all sql required files to update database',
            'fr' => 'Exécute tous les fichiers nécessaires pour mettre à jour la base de données'
        ]);

        self::generateTranslation('no_version', [
            'en' => 'Your ClipBucket use the old database upgrade system. Please execute all sql \Migration files to version 5.3.0 before continue.',
            'fr' => 'Votre ClipBucket utilise l\'ancien système de mise à jour. Merci d\'exéctuer les fichiers de \Migration jusqu\'à la version 5.3.0. avant de poursuivre.'
        ]);

        self::generateTranslation('select_version', [
            'en' => 'Please select you current version and revision',
            'fr' => 'Merci de sélectionner votre version et révision courante.'
        ]);

        self::generateTranslation('version', [
            'en' => 'version',
            'fr' => 'version'
        ]);

        self::generateTranslation('revision', [
            'en' => 'revision',
            'fr' => 'révision'
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}version`(
            `id`       INT(11)     NOT NULL,
            `version`  VARCHAR(16) NOT NULL,
            `revision` INT(11)     NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}version` (id, version, revision) VALUES (1, \'5.5.0\', 169);';
        self::query($sql);

    }

}