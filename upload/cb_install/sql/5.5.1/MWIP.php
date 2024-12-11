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
            code VARCHAR(32),
            is_default BOOLEAN DEFAULT FALSE,
            is_deletable BOOLEAN DEFAULT TRUE,
            content TEXT,
            disabled BOOLEAN DEFAULT FALSE,
            code_unique_for_enable VARCHAR(32) GENERATED ALWAYS AS ( CASE WHEN disabled = FALSE THEN code ELSE NULL END ) UNIQUE 
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);


        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email` (
            id_email INT PRIMARY KEY AUTO_INCREMENT,
            code VARCHAR(32),
            id_email_template INT,
            is_deletable BOOLEAN DEFAULT TRUE,
            title  VARCHAR(256),
            content TEXT,
            disabled BOOLEAN DEFAULT FALSE,
            code_unique_for_enable VARCHAR(32) GENERATED ALWAYS AS ( CASE WHEN disabled = FALSE THEN code ELSE NULL END ) UNIQUE 
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
            `userid` BIGINT(20) NULL,
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

        self::generateTranslation('empty_email_content', [
            'fr' => 'Merci de renseigner la variable "email_content".',
            'en' => 'Please enter variable "email_content"'
        ]);

        self::generateTranslation('rendered', [
            'fr' => 'Rendu',
            'en' => 'Rendered'
        ]);

        self::generateTranslation('code_cannot_be_empty', [
            'fr' => 'Le code ne peut pas être vide',
            'en' => 'Code cannot be empty'
        ]);
        self::generateTranslation('title_cannot_be_empty', [
            'fr' => 'Le titre ne peut pas être vide',
            'en' => 'Title cannot be empty'
        ]);

        self::generateTranslation('back_to_list', [
            'fr' => 'Retour à la liste',
            'en' => 'Back to list'
        ]);

        self::generateTranslation('code_already_exist', [
            'fr' => 'Ce code existe déjà. Merci d\'en choisir un autre',
            'en' => 'This code already exists. Please chose another'
        ]);
        self::generateTranslation('template_set_default', [
            'fr' => 'Le modèle %s a été enregistré par défaut',
            'en' => 'Template %s has been set to default'
        ]);

        self::generateTranslation('confirm_default_template', [
            'fr' => 'Voulez-vous appliquer ce nouveau modèle d\'email par défaut à tous les emails existants ?',
            'en' => 'Do you want to apply this new default email template to all existing emails ?'
        ]);

        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'email_content\',\'template\', \'email_variable_content\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_title\',\'title\', \'email_variable_website_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_username\',\'title\', \'email_variable_user_username\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_version\',\'title\', \'email_variable_website_version\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_revision\',\'title\', \'email_variable_website_revision\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_title\',\'email\', \'email_variable_website_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_username\',\'email\', \'email_variable_user_username\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_version\',\'email\', \'email_variable_website_version\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_revision\',\'email\', \'email_variable_website_revision\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_avatar\',\'email\', \'email_variable_user_avatar\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'url\',\'email\', \'email_variable_url\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'code\',\'email\', \'email_variable_code\')';
        self::query($sql);
        self::generateTranslation('email_variable_content', [
            'fr' => 'Cette variable sera remplacée par le contenu de l\'email',
            'en' => 'This variable will be remplaced with email content'
        ]);
        self::generateTranslation('email_variable_website_title', [
            'fr' => 'Contient le titre du site',
            'en' => 'The website title'
        ]);
        self::generateTranslation('email_variable_user_username', [
            'fr' => 'Nom d\'utilisateur',
            'en' => 'Username'
        ]);
        self::generateTranslation('email_variable_website_version', [
            'fr' => 'Version du site',
            'en' => 'Website version'
        ]);
        self::generateTranslation('email_variable_website_revision', [
            'fr' => 'Révision du site',
            'en' => 'Website revision'
        ]);
        self::generateTranslation('email_variable_user_avatar', [
            'fr' => 'URL de l\'avatar de l\'utilisateur',
            'en' => 'User avatar\'s URL'
        ]);
        self::generateTranslation('email_variable_url', [
            'fr' => 'URL',
            'en' => 'URL'
        ]);
        self::generateTranslation('email_variable_code', [
            'fr' => 'Code',
            'en' => 'Code'
        ]);
        self::generateTranslation('success', [
            'fr' => 'Opération réalisée avec succès',
            'en' => 'Operation completed successfully'
        ]);
        self::generateTranslation('sender', [
            'fr' => 'Expéditeur',
            'en' => 'Sender'
        ]);
        self::generateTranslation('email_sender', [
            'fr' => 'Adresse email de l\'expéditeur',
            'en' => 'Sender\'s email'
        ]);
        self::generateTranslation('recipient', [
            'fr' => 'Destinataire',
            'en' => 'Recipient'
        ]);
        self::generateTranslation('email_recipient', [
            'fr' => 'Adresse email du destinataire',
            'en' => 'Recipient\'s email'
        ]);
        self::generateTranslation('select_an_email', [
            'fr' => 'Choisissez un email',
            'en' => 'Choose an email'
        ]);
        self::generateTranslation('content', [
            'fr' => 'Contenu',
            'en' => 'Content'
        ]);
        self::generateTranslation('invalid_email_recipient', [
            'fr' => 'Merci de saisir une adresse de destination valide',
            'en' => 'Please provide a valid recipient email address'
        ]);
        self::generateTranslation('invalid_email_sender', [
            'fr' => 'Merci de saisir une adresse d\'expédition valide',
            'en' => 'Please provide a valid sender email address'
        ]);

        $config_email_sender = config('website_email');
        self::deleteConfig('website_email');
        if (empty($config_email_sender)) {
            $config_email_sender = config('support_email');
        }
        self::deleteConfig('support_email');
        if (empty($config_email_sender)) {
            $config_email_sender = config('welcome_email');
        }
        self::deleteConfig('welcome_email');
        self::generateConfig('email_sender_address', $config_email_sender);
        self::generateConfig('email_sender_name', 'no-reply');

        self::generateTranslation('missing_recipient', [
            'fr'=>'Destinataire manquant',
            'en'=>'Missing recipient'
        ]);

        self::generateTranslation('unknown_email', [
            'fr'=>'Email inconnu',
            'en'=>'Unknown email'
        ]);

        self::generateTranslation('template_dont_exist', [
            'fr'=>'Ce modèle d\'email n\'existe pas',
            'en'=>'Template doesn\'t exists'
        ]);
    }
}
