<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00255 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}flag_element_type`
        (
            `id_flag_element_type` INT         NOT NULL AUTO_INCREMENT,
            `name`                 VARCHAR(32) NOT NULL UNIQUE ,
            PRIMARY KEY (`id_flag_element_type`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}flag_type`
        (
            `id_flag_type` INT NOT NULL AUTO_INCREMENT,
            `language_key` VARCHAR(32) NOT NULL UNIQUE ,
            PRIMARY KEY (`id_flag_type`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('flag_element_type') . ' (`name`) SELECT name FROM ' . tbl('categories_type');
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('flag_type') . '  (`language_key`) VALUES 
            (\'inapp_content\'),
            (\'copyright_infring\'),
            (\'sexual_content\'),
            (\'violence_replusive_content\'),
            (\'spam\'),
            (\'disturbing\'),
            (\'other\') ';
        self::query($sql);

        self::alterTable('ALTER TABLE ' . tbl('flags') . ' RENAME ' . tbl('flags_temp'), [
            'table' => 'flags'
            ,'column' => 'flag_type'
        ], [
            'table' => 'flags_temp'
        ]);

        self::query('DROP TABLE IF EXISTS `{tbl_prefix}flags`');
        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}flags` (
              `flag_id` INT(225) NOT NULL AUTO_INCREMENT,
              `id_flag_element_type` INT NOT NULL,
              `id_element` INT(225) NOT NULL,
              `userid` BIGINT(20) NOT NULL,
              `id_flag_type` INT NOT NULL,
              `date_added` DATETIME NOT NULL,
              PRIMARY KEY (`flag_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;');

        $sql = 'ALTER TABLE `{tbl_prefix}flags`
                            ADD CONSTRAINT `fk_id_flag_element_type` FOREIGN KEY (`id_flag_element_type`) REFERENCES `{tbl_prefix}flag_element_type` (`id_flag_element_type`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'flags',
            'column' => 'id_flag_element_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_element_type'
            ]
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}flags`
                            ADD CONSTRAINT `fk_id_flag_type` FOREIGN KEY (`id_flag_type`) REFERENCES `{tbl_prefix}flag_type` (`id_flag_type`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'flags',
            'column' => 'id_flag_type'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_id_flag_type'
            ]
        ]);
        $sql = 'ALTER TABLE `{tbl_prefix}flags`
                            ADD CONSTRAINT `fk_flag_userid` FOREIGN KEY (`userid`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION';
        self::alterTable($sql, [
            'table'  => 'flags',
            'column' => 'userid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'fk_flag_userid'
            ]
        ]);

        self::constrainedQuery('
            INSERT INTO `{tbl_prefix}flags` (`id_flag_element_type`, `id_element`, `userid`, `id_flag_type`, `date_added`) 
            SELECT FET.id_flag_element_type, FT.id, FT.userid, FT.flag_type+1, FT.date_added FROM `{tbl_prefix}flags_temp` FT 
            INNER JOIN `{tbl_prefix}flag_element_type` FET 
                ON ( CASE 
                    WHEN FT.type = \'v\' THEN FET.name = \'video\' 
                    WHEN FT.type = \'p\' THEN FET.name = \'photo\' 
                    WHEN FT.type = \'u\' THEN FET.name = \'user\' 
                    WHEN FT.type = \'cl\' THEN FET.name = \'collection\' 
                END)
        ', [
            'table' => 'flags_temp'
        ]);

        self::generateTranslation('element', [
            'fr'=>'Élément',
            'en'=>'element'
        ]);
        self::generateTranslation('motif', [
            'fr'=>'Motif',
            'en'=>'Reason'
        ]);
        self::generateTranslation('reporter', [
            'fr'=>'Rapporteur',
            'en'=>'Reporter'
        ]);
        self::generateTranslation('unflag', [
            'fr'=>'Annuler le signalement',
            'en'=>'Unflag'
        ]);
        self::generateTranslation('delete_element', [
            'fr'=>'Supprimer l\'élément',
            'en'=>'Delete element'
        ]);
        self::generateTranslation('unflag_and_activate', [
            'fr'=>'Annuler le signalement et activer',
            'en'=>'Unflag and activate'
        ]);
        self::generateTranslation('video_flagged', [
            'fr'=>'Vidéos signalées',
            'en'=>'Flagged videos'
        ]);
        self::generateTranslation('user_flagged', [
            'fr'=>'Utilisateurs signalés',
            'en'=>'Flagged users'
        ]);
        self::generateTranslation('collection_flagged', [
            'fr'=>'Collections signalées',
            'en'=>'Flagged collections'
        ]);
        self::generateTranslation('playlist_flagged', [
            'fr'=>'Playlists signalées',
            'en'=>'Flagged playlists'
        ]);
        self::generateTranslation('photo_flagged', [
            'fr'=>'Photos signalées',
            'en'=>'Flagged photos'
        ]);
        self::generateTranslation('report_successful', [
            'fr'=>'Le signalement a été effectué avec succès',
            'en'=>'Report successfully'
        ]);
        self::generateTranslation('unflag_successful', [
            'fr'=>'Le signalement a été annulé',
            'en'=>'Unflag successfully'
        ]);
        self::generateTranslation('element_deleted', [
            'fr'=>'L\'élément a été supprimé',
            'en'=>'Element has been deleted'
        ]);
        self::generateTranslation('nb_flag', [
            'fr'=>'Nombre de signalement',
            'en'=>'Number of flags'
        ]);
        self::updateTranslation('sexual_content', [
            'fr'=>'Contenu à caractère sexuel'
        ]);
        self::generateTranslation('flagged_obj', [
            'fr'=>'Éléments signalés'
        ]);
        self::generateTranslation('flagged', [
            'fr'=>'Signalé',
            'en'=>'Flagged'
        ]);
        self::generateTranslation('must_update_version', [
            'fr'=>'Votre base de donnée nécessite d\'être mise à jour',
            'en'=>'Your database needs to be updated'
        ]);

        self::query('DROP TABLE IF EXISTS ' . tbl('flags_temp'));
    }
}