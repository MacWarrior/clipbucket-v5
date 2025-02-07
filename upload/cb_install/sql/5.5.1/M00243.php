<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00243 extends \Migration
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
            code VARCHAR(32) NOT NULL UNIQUE ,
            type ENUM(\'global\', \'email\', \'template\'),
            language_key VARCHAR(256)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}email_variable_link` (
            id_email_variable INT NOT NULL ,
            id_email INT NOT NULL ,
            PRIMARY KEY (`id_email_variable`, `id_email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}email_variable_link`
            ADD CONSTRAINT `email_variable_link_email_variable_fk` FOREIGN KEY (`id_email`) REFERENCES `{tbl_prefix}email` (`id_email`) ON DELETE NO ACTION ON UPDATE NO ACTION;',
            [
                'table'  => 'email_variable_link',
                'column' => 'id_email'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'email_variable_link_email_variable_fk'
                ]
            ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}email_variable_link`
            ADD CONSTRAINT `email_variable_link_email_variable_email_fk` FOREIGN KEY (`id_email_variable`) REFERENCES `{tbl_prefix}email_variable` (`id_email_variable`) ON DELETE NO ACTION ON UPDATE NO ACTION;',
            [
                'table'  => 'email_variable_link',
                'column' => 'id_email_variable'
            ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'email_variable_link_email_variable_email_fk'
                ]
            ]);

        self::generatePermission(3, 'email_template_management', 'email_template_management_desc', [
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

        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'website_title\',\'global\', \'email_variable_website_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_username\',\'global\', \'email_variable_user_username\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_email\',\'global\', \'email_variable_user_email\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_avatar\',\'global\', \'email_variable_user_avatar\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'date_year\',\'global\', \'email_variable_date_year\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'baseurl\',\'global\', \'email_variable_baseurl\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'date_time\',\'global\', \'email_variable_date_time\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'login_link\',\'global\', \'email_variable_login_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'logo_url\',\'global\', \'email_variable_logo_url\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'favicon_url\',\'global\', \'email_variable_favicon_url\')';
        self::query($sql);

        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_link\',\'email\', \'email_variable_video_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_title\',\'email\', \'email_variable_video_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_thumb\',\'email\', \'email_variable_video_thumb\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_description\',\'email\', \'email_variable_video_description\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'sender_message\',\'email\', \'email_variable_sender_message\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'avcode\',\'email\', \'email_variable_avcode\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'subject\',\'email\', \'email_variable_subject\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'sender_username\',\'email\', \'email_variable_sender_username\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'sender_email\',\'email\', \'email_variable_sender_email\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'profile_link\',\'email\', \'email_variable_profile_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'request_link\',\'email\', \'email_variable_request_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'photo_link\',\'email\', \'email_variable_photo_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'photo_thumb\',\'email\', \'email_variable_photo_thumb\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'photo_description\',\'email\', \'email_variable_photo_description\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'photo_title\',\'email\', \'email_variable_photo_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'collection_link\',\'email\', \'email_variable_collection_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'collection_thumb\',\'email\', \'email_variable_collection_thumb\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'collection_description\',\'email\', \'email_variable_collection_description\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'collection_title\',\'email\', \'email_variable_collection_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'total_items\',\'email\', \'email_variable_total_items\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'collection_type\',\'email\', \'email_variable_collection_type\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'private_message_link\',\'email\', \'email_variable_private_message_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'password\',\'email\', \'email_variable_password\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'reset_password_link\',\'email\', \'email_variable_reset_password_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'comment_link\',\'email\', \'email_variable_comment_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'object\',\'email\', \'email_variable_object\')';
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
            'fr' => 'Nom d\'utilisateur du destinataire',
            'en' => 'Receiver\'s username'
        ]);
        self::generateTranslation('email_variable_user_avatar', [
            'fr' => 'URL de l\'avatar du destinataire',
            'en' => 'Receiver\'s avatar URL'
        ]);
        self::generateTranslation('email_variable_date_year', [
            'fr'=>'Année en cours',
            'en'=>'Current year'
        ]);
        self::generateTranslation('email_variable_baseurl', [
            'fr'=>'URL du site web',
            'en'=>'Website URL'
        ]);
        self::generateTranslation('email_variable_date_time',[
            'fr'=>'Date et heure de la création du mail',
            'en'=>'Date and time of mail creation'
        ]);
        self::generateTranslation('email_variable_login_link', [
            'fr'=>'Lien vers la page de connexion',
            'en'=>'Link to login page'
        ]);
        self::generateTranslation('email_variable_logo_url', [
            'fr'=>'Lien vers le logo du site',
            'en'=>'Link to website logo'
        ]);
        self::generateTranslation('email_variable_favicon_url', [
            'fr'=>'Lien vers l\'icone du site',
            'en'=>'Link to website favicon'
        ]);

        self::generateTranslation('email_variable_avcode', [
            'fr' => 'Code de validation de compte',
            'en' => 'Account validation code'
        ]);

        self::generateTranslation('email_variable_video_link', [
            'fr'=>'Lien vers la vidéo',
            'en'=>'Link to video'
        ]);
        self::generateTranslation('email_variable_video_title', [
            'fr'=>'Titre de la vidéo',
            'en'=>'Video title'
        ]);
        self::generateTranslation('email_variable_video_thumb', [
            'fr'=>'URL de la vignette de la vidéo',
            'en'=>'Video thumb URL'
        ]);
        self::generateTranslation('email_variable_video_description', [
            'fr'=>'Description de la vidéo',
            'en'=>'Video description'
        ]);

        self::generateTranslation('email_variable_sender_message', [
            'fr'=>'Contenu du message',
            'en'=>'Message content'
        ]);
        self::generateTranslation('email_variable_subject',[
            'fr'=>'Sujet du message',
            'en'=>'Message subject'
        ]);

        self::generateTranslation('email_variable_profile_link', [
            'fr'=>'Lien vers le profile de l\'utilisateur',
            'en'=>'Link to user profil'
        ]);
        self::generateTranslation('email_variable_request_link',[
            'fr'=>'Lien vers la demande d\'ami',
            'en'=>'Link to friend request'
        ]);
        self::generateTranslation('email_variable_photo_link', [
            'fr'=>'Lien vers la photo',
            'en'=>'Link to photo'
        ]);
        self::generateTranslation('email_variable_photo_thumb',[
            'fr'=>'URL vers la miniature de la photo',
            'en'=>'URL to photo\'s thumb'
        ]);
        self::generateTranslation('email_variable_photo_description', [
            'fr'=>'Description de la photo',
            'en'=>'Photo description'
        ]);
        self::generateTranslation('email_variable_photo_title', [
            'fr'=>'Titre de la photo',
            'en'=>'Photo title'
        ]);
        self::generateTranslation('email_variable_collection_link', [
            'fr'=>'Lien vers la collection',
            'en'=>'Link to collection'
        ]);
        self::generateTranslation('email_variable_collection_thumb', [
            'fr'=>'URL vers la vignette de la collection',
            'en'=>'URL to collection\'s thumb'
        ]);
        self::generateTranslation('email_variable_collection_description', [
            'fr'=>'Description de la collection',
            'en'=>'Collection description'
        ]);
        self::generateTranslation('email_variable_collection_title', [
            'fr'=>'Titre de la collection',
            'en'=>'Collection title'
        ]);
        self::generateTranslation('email_variable_total_items', [
            'fr'=>'Nombre d\'éléments dans la collections',
            'en'=>'Number of item inside the collection'
        ]);
        self::generateTranslation('email_variable_collection_type', [
            'fr'=>'Type d\'objet de la collection (vidéo, photo, etc.)',
            'en'=>'Object type for the collection (video, photo, etc.)'
        ]);
        self::generateTranslation('email_variable_private_message_link', [
            'fr'=>'Lien vers le message dans la boite de reception',
            'en'=>'Link to message in inbox'
        ]);
        self::generateTranslation('email_variable_password',[
            'fr'=>'Mot de passe généré',
            'en'=>'Generated password'
        ]);
        self::generateTranslation('email_variable_reset_password_link', [
            'fr'=>'Lien pour la réinitialisation du mot de passe',
            'en'=>'Link to reset password'
        ]);
        self::generateTranslation('email_variable_comment_link', [
            'fr'=>'Lien vers le commentaire',
            'en'=>'Link to comment'
        ]);
        self::generateTranslation('email_variable_object', [
            'fr'=>'Type d\'object cité dans l\'email (vidéo, photo etc.)',
            'en'=>'Object type in the mail (video, photo, etc.)'
        ]);

        self::generateTranslation('email_variable_sender_username', [
            'fr' => 'Nom d\'utilisateur à l\'origine du message',
            'en' => 'Username responsible for the message'
        ]);
        self::generateTranslation('email_variable_sender_email', [
            'fr' => 'Adresse email de l\'expéditeur',
            'en' => 'Sender\'s email'
        ]);

        self::generateTranslation('email_variable_user_email', [
            'fr'=>'Adresse email du destinataire',
            'en'=>'Receiver\'s email'
        ]);

        //variables translation
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

        self::generateTranslation('email_sender_address', [
            'fr' => 'Adresse d\'expédition des emails',
            'en' => 'Email sender address'
        ]);
        self::generateConfig('email_sender_name', 'no-reply');
        self::generateTranslation('email_sender_name', [
            'fr' => 'Nom de l\'expéditeur des emails',
            'en' => 'Email sender mail'
        ]);

        self::generateTranslation('missing_recipient', [
            'fr' => 'Destinataire manquant',
            'en' => 'Missing recipient'
        ]);

        self::generateTranslation('unknown_email', [
            'fr' => 'Email inconnu',
            'en' => 'Unknown email'
        ]);

        self::generateTranslation('template_dont_exist', [
            'fr' => 'Ce modèle d\'email n\'existe pas',
            'en' => 'Template doesn\'t exists'
        ]);

        $sql = 'INSERT IGNORE INTO ' . tbl('email_template') . ' (code, is_default, is_deletable, content, disabled) VALUE (\'main\', TRUE, FALSE, \'<html>\r\n	<body>\r\n		<div style=\"background-color: #EEEEEE;padding-bottom:10px;\">\r\n				<div style=\"background-color:#0080B4;padding-top:10px;padding-bottom:110px;text-align:center;\">\r\n				<a href=\"{{baseurl}}\"><img src=\"{{logo_url}}\" title=\"{{website_title}}\" alt=\"logo\" style=\"background-color: white;border-radius:10px;\"/></a>\r\n				<div style=\"color: white;margin-top:10px;font-size:22px;\">{{website_title}}</div>\r\n			</div>\r\n			<div style=\"background-color: white;width:90%;margin:auto;margin-top:-60px;border-radius:10px;min-height:100px;padding:10px;\">\r\n				{{email_content}}\r\n			</div>\r\n			<div style=\"background-color: #0080B4;width:90%;margin:auto;border-radius:10px;min-height:70px;color:white;margin-top:10px;padding:10px;\">\r\n				<a href=\"{{baseurl}}\" style=\"float:left;\"><img src=\"{{favicon_url}}\" title=\"{{website_title}}\" alt=\"logo\" style=\"background-color:white;border-radius: 10px;width:50px;height:50px;\"/></a>\r\n				<div style=\"text-align:center;line-height:50px;vertical-align:middle;\">\r\n					<a href=\"https://clipbucket.fr\" style=\"color:white;text-decoration:none;\">&copy;ClipBucketV5</a>, maintained by <a href=\"https://oxygenz.fr\" style=\"color:white;text-decoration:none;\">Oxygenz</a>\r\n				</div>\r\n			</div>\r\n		</div>\r\n	</body>\r\n</html>\', FALSE)';
        self::query($sql);
        $inserted_template = \Clipbucket_db::getInstance()->insert_id();
        if (empty($inserted_template)) {
            $inserted_template = \EmailTemplate::getOneTemplate(['code' => 'main'])['id_email_template'] ?? 0;
        }

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'share_video\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} wants to share a video with you\',
            \'<b>{{sender_username}}</b> wants to share a video with you :
            
            <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
                <a href="{{video_link}}">
                    <img src="{{video_thumb}}" title="{{video_title}}" alt="Video thumb"><br/>
                    {{video_title}}
                </a>
            </div>
            
            <div style="margin-bottom:10px;">
                <b>Video Description</b> : <br/>
                {{video_description}}
            </div>
            
            <div style="margin-bottom:10px;">
                <b>Personal Message</b> : <br/>
                {{sender_message}}
            </div>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'share_photo\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} wants to share a photo with you\',
            \'<b>{{sender_username}}</b> wants to share a photo with you :
        
            <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
                <a href="{{photo_link}}">
                    <img src="{{photo_thumb}}" title="{{photo_title}}" alt="Photo thumb"><br/>
                    {{photo_title}}
                </a>
            </div>
        
            <div style="margin-bottom:10px;">
                <b>Photo Description</b> : <br/>
                {{photo_description}}
            </div>
        
            <div style="margin-bottom:10px;">
                <b>Personal Message</b> : <br/>
                {{sender_message}}
            </div>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'share_collection\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} wants to share a collection with you\',
            \'<b>{{sender_username}}</b> wants to share a {{collection_type}} collection with you :

            <div style="text-align:center;margin-top:10px;margin-bottom:10px;">
                <a href="{{collection_link}}">
                    <img src="{{collection_thumb}}" title="{{collection_title}}" alt="Collection thumb"><br/>
                    {{collection_title}}
                </a>
            </div>
        
            <div style="margin-bottom:10px;">
                <b>Collection Description</b> : <br/>
                {{collection_description}}
            </div>
        
            <div style="margin-bottom:10px;">
                <b>Personal Message</b> : <br/>
                {{sender_message}}
            </div>\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'verify_account\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Email address verification\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            Thanks for registering on <a href="{{baseurl}}">{{website_title}}</a> !<br/>
            In order to verify your email address, please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
            <br/><br/>
            If somehow above link isn\\\'t working, please go to : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
            And use your activation code : <b>{{avcode}}</b>
            <br/><br/>
            Welcome aboard !\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'private_message\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} has sent you a private message\',
            \'Hello {{user_username}},
            <br/><br/>
            <b>{{sender_username}}</b> has sent you a private message :
            <hr/>
            Title : <i>{{subject}}</i><br/>
            "{{sender_message}}"
            <hr/>
            Click here to view your inbox <a href="{{message_link}}">Inbox</a>\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'avcode_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Account activation\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            Please validate your account by <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">clicking here !</a>
            <br/><br/>
            If somehow above link isn\\\'t working, please go to : <a href="{{baseurl}}activation.php">{{baseurl}}activation.php</a><br/>
            And use your activation code : <b>{{avcode}}</b>
            <br/><br/>
            Welcome aboard !\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'welcome_message\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Welcome onboard !\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            Welcome to <a href="{{baseurl}}">{{website_title}}</a> !\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'password_reset_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Password reset\',
            \'Dear <b>{{user_username}}</b>,
            <br/><br/>
            You have requested a password reset, please follow the link in order to reset your password : <br/>
            <a href="{{reset_password_link}}">Reset my password</a>
            <hr/>
            <div style="text-align:center;font-weight:bold;">
            If you have not requested a password reset, please ignore this message
            </div>
            <hr/>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'password_reset_details\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Password reset details\',
            \'Dear <b>{{user_username}}</b>,<br/><br/>
            Your password has been manually reset.<br/>
            Your new temporary password is : <b>{{password}}</b>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'forgot_username_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Your username\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            It seems you forgot your username ; here it is : <b>{{user_username}}</b>.\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'friend_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Friend request from {{user_username}}\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            <a href="{{profile_link}}"><b>{{sender_username}}</b></a> sent you a friend request.<br/>
            <hr/>
            <div style="text-align:center;">
            <a href="{{profile_link}}">Click here to view his profile</a><br/><br/>
            <a href="{{request_link}}"> Click here to respond to friend request</a>
            </div>
            <hr/>\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'friend_confirmation\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Friend request confirmation\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            <a href="{{profile_link}}" title="{{sender_username}}">{{sender_username}}</a> confirmed your friend invitation !<br/>
            <hr/>
            <div style="text-align:center;">
            <a href="{{profile_link}}">View {{sender_username}} profile</a>
            </div>
            <hr/>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'contact_form\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Contact form\',
            \'<b>Name</b> : {{sender_username}}<br/>
            <b>Email</b> : {{sender_email}}<br/>
            <b>Reason</b> : {{subject}}
            <hr/>
            <b>Message</b> :<br/>
            {{sender_message}}
            <hr/>\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'video_activation\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] Your video has been activated\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            
            Your video <a href="{{video_link}}" title={{video_title}}>{{video_title}}</a> has been reviewed and activated by one of our staff, thanks for uploading this video.<br/>
            Watch it <a href="{{video_link}}"><b>here</b></a>.\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_comment\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} made comment on your {{object}}\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            {{sender_username}} has commented on your {{object}} : <br/>
            "{{sender_message}}"
            <hr/>
            <div style="text-align:center;">
            <a href="{{comment_link}}">View comment</a>
            </div>
            <hr/>\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_reply\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} replied on your comment\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            {{sender_username}} has replied on your comment : <br/>
            "{{sender_message}}"
            <hr/>
            <div style="text-align:center;">
            <a href="{{comment_link}}">View comment</a>
            </div>
            <hr/>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'video_subscription\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} just uploaded a new video\',
            \'Hello <b>{{user_username}}</b>,
            <br/><br/>
            {{sender_username}} just uploaded new video !
            <br/><br/>
            <div style="text-align:center;">
            <a href="{{video_link}}" title="{{video_title}}">
                    <img src="{{video_thumb}}" border="0" height="90" width="120"><br/>
                     {{video_title}}
            </a>
            </div>
            <br/>
            Video Description : {{video_description}}
            
            <hr/>
            <i>You are notified because you subscribed to {{sender_username}}, you can manage your subscriptions by going to your account and click on manage subscriptions.</i>
            <hr/>\',
            FALSE
        )';
        self::query($sql);

        self::generateTranslation('error_mail', [
            'fr' => 'Une erreur est survenue lors de l\'envoi du mail : %s',
            'en' => 'An error occurred during mail sending : %s'
        ]);
        self::updateTranslation('email_template', [
            'en' => 'Email template'
        ]);

        $sql = 'INSERT IGNORE INTO `' . tbl('email_variable_link') . '` (`id_email`, `id_email_variable`) 
        VALUES
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_photo\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_thumb\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'total_items\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_type\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_collection\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'verify_account\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'avcode\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'private_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'private_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'subject\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'private_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'private_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'message_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'avcode_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'avcode\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'password_reset_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'reset_password_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'password_reset_details\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'password\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'password_reset_details\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'login_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'friend_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'profile_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'request_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'friend_confirmation\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_confirmation\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'profile_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'subject\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_email\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'video_activation\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_activation\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_title\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'user_comment\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'object\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'user_reply\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_reply\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_reply\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'comment_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'video_subscription\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1));
        ';
        self::query($sql);

        self::generateTranslation('email_specific', [
            'fr'=>'Spécifique à l\'email',
            'en'=>'Email specific'
        ]);

        self::generateTranslation('title_email_variables', [
            'fr'=>'Variables utilisables dans l\'email',
            'en'=>'Usable variables in email'
        ]);

        self::generateTranslation('tips_email_variables', [
            'fr'=>'Les variables doivent être placées entre doubles accolades, par exemple : {{website_title}}',
            'en'=>'Variables must be placed into double braces, per example : {{website_title}}'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}email_templates` DROP `email_template_allowed_tags`', [
            'table' => 'email_templates',
            'column' =>'email_template_allowed_tags'
        ]);

        self::generateTranslation('cannot_remove_default_have_to_add_one', [
            'fr'=>'Impossible de retirer le modèle par défaut, merci d\'en choisir un nouveau',
            'en'=>'Cannot remove default template, please choose another'
        ]);
    }
}
