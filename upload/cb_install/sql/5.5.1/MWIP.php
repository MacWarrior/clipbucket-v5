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
            code VARCHAR(32) NOT NULL UNIQUE ,
            type ENUM(\'global\', \'email\'),
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

        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_link\',\'email\', \'email_variable_video_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_title\',\'email\', \'email_variable_video_title\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_thumb\',\'email\', \'email_variable_video_thumb\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'video_description\',\'email\', \'email_variable_video_description\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_message\',\'email\', \'email_variable_user_message\')';
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

        self::generateTranslation('email_variable_user_message', [
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

        $sql = 'INSERT IGNORE INTO ' . tbl('email_template') . ' (code, is_default, is_deletable, content, disabled) VALUE (\'main\', TRUE, FALSE, \'<html ><body>{{email_content}}<hr>Regards,<br>ClipBucket Team</body></html>\', FALSE)';
        self::query($sql);
        $inserted_template = \Clipbucket_db::getInstance()->insert_id();
        if (empty($inserted_template)) {
            $inserted_template = \EmailTemplate::getOneTemplate(['code' => 'main'])['id_email_template'] ?? 0;
        }

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'share_video_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{sender_username}} wants to share a video with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td bgcolor="#53baff" ><span class="title">{{website_title}}</span>share video</td>
                  </tr>
                  <tr>
                    <td height="20" class="messege">{{sender_username}} wants to share Video With You
                      <div id="videoThumb"><a href="{{video_link}}"><img src="{{video_thumb}}"><br>
                    watch video</a></div></td>
                  </tr>
                  <tr>
                    <td class="text" ><span class="title2">Video Description</span><br>
                      <span class="text">{{video_description}}</span></td>
                  </tr>
                  <tr>
                    <td><span class="title2">Personal Message</span><br>
                      <span class="text">{{user_message}}
                      </span><br>
                      <br>
                <span class="text">Thanks,</span><br> 
                <span class="text">{{website_title}}</span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#53baff">copyrights {{date_year}} {{website_title}}</td>
                  </tr>
                </table>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'photo_share_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{sender_username}} wants to share a photo with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
                 <tr>
                      <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
                 </tr>
            
                 <tr>
                      <td height="20" class="messege">{{sender_username}} wants to share this photo with you<br>
                           <div id="videoThumb"><a class="text" href="{{photo_link}}" title="{{photo_title}}"><img src="{{photo_thumb}}"><br>
                      View Photo</a></div></td>
                 </tr>
                 <tr>
                      <td class="text" ><span class="title2">Photo Description</span><br>
                           <span class="text">{{photo_description}}</span></td>
                 </tr>
                 <tr>
                      <td><span class="title2">Personal Message</span><br>
                           <span class="text">{{user_message}}
                           </span><br>
                           <br>
                    <span class="text">Thanks,</span><br> 
                    <span class="text">{{website_title}}</span></td>
                 </tr>
                 <tr>
                      <td bgcolor="#0099cc">copyrights {{date_year}} {{website_title}}</td>
                 </tr>
            </table>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'collection_share_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{sender_username}} wants to share a collection with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
             <tr>
                  <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
             </tr>
        
             <tr>
                  <td height="20" class="messege">{{sender_username}} wants to share this collection with you.<br>
                       <div id="videoThumb"><a class="text" href="{{collection_link}}" title="{{collection_title}}"><img src="{{collection_thumb}}"><br>
                  View Collection <small class="text2">({{total_items}} {{collection_type}})</small></a></div></td>
             </tr>
             <tr>
                  <td class="text" ><span class="title2">Collection Description</span><br>
                       <span class="text">{{collection_description}}</span></td>
             </tr>
             <tr>
                  <td><span class="title2">Personal Message</span><br>
                       <span class="text">{{user_message}}
                       </span><br>
                       <br>
                    <span class="text">Thanks,</span><br> 
                    <span class="text">{{website_title}}</span></td>
             </tr>
             <tr>
                  <td bgcolor="#0099cc">copyrights {{date_year}} {{website_title}}</td>
             </tr>
        </table>\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'email_verify_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}]- Account activation email\',
            \'Hello {{user_username}},
            Thank you for joining {{website_title}}, one last step is required in order to activate your account

            <a href="{{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}">Click Here</a>
            
            Email           : {{user_email}}
            Username        : {{user_username}}
            Activation code : {{avcode}}
            
            if above given is not working , please go here and activate it
            <a href="{{baseurl}}activation.php">Activate</a>\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'pm_email_message\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{sender_username}} has sent you a private message\',
            \'{{sender_username}} has sent you a private message, 

                {{subject}}
                "{{user_message}}"
                
                click here to view your inbox <a href="{{message_link}}">Inbox</a>
                
                {{website_title}}\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'avcode_request_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{website_title}] - Account activation code request\',
            \'Hello {{user_username}},
                
                Your Activation Code is : {{avcode}}
                <a   href="{{url}}activation.php?av_username={{user_username}}&avcode={{avcode}}">Click Here</a> To goto Activation Page
                
                Direct Activation
                ==========================================
                Click Here or Copy & Paste the following link in your browser
                {{baseurl}}activation.php?av_username={{user_username}}&avcode={{avcode}}
                
                if above given links are not working, please go here and activate it
                
                Email           : {{user_email}}
                Username        : {{user_username}}
                Activation code : {{avcode}}
                
                if above given is not working , please go here and activate it
                <a  href="{{baseurl}}activation.php">{{baseurl}}activation.php</a>
                
                ----------------
                Regards
                {{website_title}}\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'welcome_message_template\',
            ' . $inserted_template . ',
            FALSE,
            \'Welcome {{user_username}} to {{website_title}}\',
            \'Hello {{user_username}},
            Thanks for joining at {{website_title}}!, you are now part of our community and we hope you will enjoy your stay
            
            All the best,
            {{website_title}}\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'password_reset_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - Password reset confirmation\',
            \'Dear {{user_username}}
            you have requested a password reset, please follow the link in order to reset your password
            <a href="{{reset_password_link}}">Reset my password</a>
            
            -----------------------------------------
            IF YOU HAVE NOT REQUESTED A PASSWORD RESET - PLEASE IGNORE THIS MESSAGE
            -----------------------------------------
            Regards
            {{website_title}}\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'password_reset_details\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - Password reset details\',
            \'Dear {{user_username}}
                your password has been reset
                your new password is : {{password}}
                
                <a href="{{login_link}}">click here to login to website</a>
                
                ---------------
                Regards
                {{website_title}}\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'forgot_username_request\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - your {{website_title}} username\',
            \'Hello,
            your {{website_title}} username is : {{user_username}}
            
            --------------
            Regards
            {{website_title}}\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'friend_request_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} add you as friend\',
            \'Hi {{user_username}},
            {{sender_username}} added you as a friend on {{website_title}}. We need to confirm that you know {{sender_username}} in order for you to be friends on {{website_title}}.
            
            <a href="{{profile_link}}">View profile of {{sender_username}}</a> 
            <a href="{{request_link}}">click here to respond to friendship request</a>
            
            Thanks,
            {{website_title}} Team\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'friend_confirmation_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{sender_username}} has confirmed you as a friend\',
            \'Hi {{user_username}},
            {{sender_username}} confirmed you as a friend on {{website_title}}.
            
            <a href="{{profile_link}}">View {{sender_username}} profile</a>
            
            Thanks,
            The {{website_title}} Team\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'contact_form\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}} - Contact] {{subject}} from {{user_username}}\',
            \'Name : {{user_username}}
                Email : {{user_email}}
                Reason : {{subject}}
                
                Message:
                {{user_message}}
                
                <hr>
                date : {{date_time}}\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'video_activation_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - Your video has been activated\',
            \'Hello {{user_username}},
                Your video has been reviewed and activated by one of our staff, thanks for uploading this video. You can view this video here.
                {{video_link}}
                
                Thanks
                {{website_title}} Team\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_comment_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} made comment on your {{object}}\',
            \'{{sender_username}} has commented on your {{object}}
                "{{user_message}}"
                
                <a href="{{comment_link}}">Read comment</a>
                
                {{website_title}} team\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_reply_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{sender_username}} made reply on your comment\',
            \'{{sender_username}} has replied on your comment
                "{{user_message}}"
                
                <a href="{{comment_link}}">Read comment</a>
                
                {{website_title}} team\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'video_subscription_email\',
            ' . $inserted_template . ',
            FALSE,
            \'{{user}} has uploaded new video on {{website_title}}\',
            \'Hello {{user_username}}

                You have been notified by {{website_title}} that {{sender_username}} has uploaded new video 
                
                Video Title : {{video_title}}
                Video Description : {{video_description}}

                <a href="{{video_link}}">
                <img src="{{video_thumb}}" border="0" height="90" width="120"><br>
                click here to watch this video</a>

                You are notified because you are subscribed to {{sender_username}}, you can manage your subscriptions by going to your account and click on manage subscriptions.
                {{website_title}}\',
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
            ((select id_email from '.tbl('email').' where code = \'share_video_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'share_video_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'photo_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'photo_thumb\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'total_items\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_type\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'collection_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'collection_share_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'email_verify_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'avcode\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'pm_email_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'pm_email_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'subject\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'pm_email_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'pm_email_message\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'message_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'avcode_request_template\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'avcode\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'password_reset_request\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'reset_password_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'password_reset_details\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'password\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'password_reset_details\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'login_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'friend_request_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_request_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'profile_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_request_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'request_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'friend_confirmation_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'friend_confirmation_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'profile_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'subject\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'contact_form\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'video_activation_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'user_comment_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'object\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_comment_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'user_reply_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_reply_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'user_message\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'user_reply_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'comment_link\' limit 1)),
            
            ((select id_email from '.tbl('email').' where code = \'video_subscription_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_title\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_description\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_link\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'video_thumb\' limit 1)),
            ((select id_email from '.tbl('email').' where code = \'video_subscription_email\' limit 1), (select id_email_variable from '.tbl('email_variable').' where code = \'sender_username\' limit 1));
        ';
        self::query($sql);

        self::generateTranslation('email_specific', [
            'fr'=>'Spécifique à l\'email',
            'en'=>'Email specific'
        ]);
    }
}
