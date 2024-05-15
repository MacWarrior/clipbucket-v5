<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00165 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools`(
            `id_tool`                  INT          NOT NULL AUTO_INCREMENT,
            `language_key_label`       VARCHAR(128) NOT NULL,
            `language_key_description` VARCHAR(128) NOT NULL,
            `function_name`            VARCHAR(128) NOT NULL,
            `id_tools_status`          INT          NOT NULL DEFAULT \'1\',
            `elements_total`           INT          NULL     DEFAULT NULL,
            `elements_done`            INT          NULL     DEFAULT NULL,
            PRIMARY KEY (`id_tool`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_status`(
            `id_tools_status`    INT          NOT NULL AUTO_INCREMENT,
            `language_key_title` VARCHAR(128) NOT NULL,
            PRIMARY KEY (`id_tools_status`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;');

        self::alterTable('ALTER TABLE `{tbl_prefix}tools` ADD FOREIGN KEY (`id_tools_status`) REFERENCES `{tbl_prefix}tools_status` (`id_tools_status`) ON DELETE RESTRICT ON UPDATE NO ACTION;', [
            'table' => 'tools',
            'column' => 'id_tools_status'
        ]);
        self::generateTranslation('admin_tool', [
            'en' => 'Administrations Tools',
            'fr' => 'Outils d\'administration'
        ]);

        self::generateTranslation('launch', [
            'en' => 'Launch',
            'fr' => 'Lancer'
        ]);

        self::generateTranslation('stop', [
            'en' => 'Stop',
            'fr' => 'Arrêter'
        ]);

        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools_status` (`language_key_title`) VALUES (\'ready\'), (\'in_progress\'), (\'stopping\');';
        self::query($sql);

        self::generateTranslation('in_progress', [
            'en' => 'In progress',
            'fr' => 'En cours'
        ]);

        self::generateTranslation('ready', [
            'en' => 'Ready',
            'fr' => 'Prêt'
        ]);

        self::generateTranslation('stopping', [
            'en' => 'Stopping',
            'fr' => 'En cours d\'arrêt'
        ]);

        self::generateTranslation('generate_missing_thumbs_label', [
            'en' => 'Generate missing thumbs',
            'fr' => 'Génération des miniatures manquantes'
        ]);

        self::generateTranslation('generate_missing_thumbs_description', [
            'en' => 'Generate thumbs for all videos without thumbs',
            'fr' => 'Génération des miniatures pour toutes les vidéos qui n\'ont pas de miniatures'
        ]);
    }
}