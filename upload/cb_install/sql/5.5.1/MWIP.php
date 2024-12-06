<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email_template` (
            id_email_template INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(32) UNIQUE,
            is_default BOOLEAN,
            is_deletable BOOLEAN,
            content TEXT,
            disabled BOOLEAN DEFAULT FALSE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email` (
            id_email INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(32) UNIQUE,
            id_email_template INT,
            is_deletable BOOLEAN,
            title  VARCHAR(256),
            content TEXT,
            disabled BOOLEAN DEFAULT FALSE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}email`
            ADD CONSTRAINT `email_template_fk` FOREIGN KEY (`id_email_template`) REFERENCES `{tbl_prefix}email_template` (`id_email_template`) ON DELETE NO ACTION ON UPDATE NO ACTION;',
            [
                'table'  => 'email',
                'column' => 'id_email_template'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'email_template_fk'
                ]
            ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email_histo` (
            id_email_histo INT PRIMARY KEY AUTO_INCREMENT,
            send_date DATETIME NOT NULL ,
            id_email INT NOT NULL ,
            `userid` BIGINT(20) NOT NULL,
            email  VARCHAR(256),
            title TEXT,
            content TEXT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}email_histo` ADD CONSTRAINT `histo_email_fk` FOREIGN KEY (`id_email`) REFERENCES `{tbl_prefix}email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;',
            [
                'table'  => 'email_histo',
                'column' => 'id_email'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'histo_email_fk'
                ]
            ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}email_histo` ADD CONSTRAINT `histo_users_fk` FOREIGN KEY (`userid`) REFERENCES `{tbl_prefix}users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;',
            [
                'table'  => 'email_histo',
                'column' => 'id_email'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'histo_users_fk'
                ]
            ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email_variable` (
            id_email_variable INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(32) NOT NULL ,
            type ENUM(\'email\', \'template\', \'title\'),
            language_key VARCHAR(256)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';

        self::alterTable('ALTER TABLE `{tbl_prefix}email_variable` ADD UNIQUE KEY unique_code_type_variable (`code`, `type`);', [
            'table'   => 'email_variable',
            'columns' => [
                'code',
                'type'
            ]
        ], [
                'constraint' => [
                    'type'  => 'UNIQUE',
                    'name'  => 'unique_code_type_variable',
                    'table' => 'email_variable'
                ]
            ]
        );
        self::query($sql);


        self::generatePermission(self::ADMINISTRATOR_ID_PERMISSION_TYPE, 'email_template_management', 'email_template_management_desc', [
            1 => 'yes',
            2 => 'no',
            3 => 'no',
            4 => 'no',
            5 => 'no',
            6 => 'no'
        ]);

        self::generateTranslation('email_template_management', [
            'fr' => 'Gestion des modèles d\'emails',
            'en' => 'Email template management'
        ]);

        self::generateTranslation('email_template_management_desc', [
            'fr' => 'Peut gérer les modèles d\'emails',
            'en' => 'Can manage emails templates'
        ]);
    }
}