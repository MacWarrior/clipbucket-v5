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

        self::generateTranslation('email_sender_address', [
            'fr'=>'Adresse d\'expédition des emails',
            'en'=>'Email sender address'
        ]);
        self::generateConfig('email_sender_name', 'no-reply');
        self::generateTranslation('email_sender_name', [
            'fr'=>'Nom de l\'expéditeur des emails',
            'en'=>'Email sender mail'
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
            $inserted_template = \EmailTemplate::getOneTemplate(['code'=>'main'])['id_email_template'] ?? 0;
        }

        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'email_content\',\'template\', \'email_variable_email_content\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'message_subject\',\'email\', \'email_variable_message_subject\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'message_subject\',\'title\', \'email_variable_message_subject\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'message_content\',\'email\', \'email_variable_message_content\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'thumb_url\',\'email\', \'email_variable_thumb_url\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'time\',\'email\', \'email_variable_time\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'receiver_name\',\'email\', \'email_variable_receiver_name\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'sender_name\',\'email\', \'email_variable_sender_name\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'request_link\',\'email\', \'email_variable_request_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'sender_link\',\'email\', \'email_variable_sender_link\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'user_email\',\'email\', \'email_variable_user_email\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'userid\',\'email\', \'email_variable_userid\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'password\',\'email\', \'email_variable_password\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'total_item\',\'email\', \'email_variable_total_item\')';
        self::query($sql);
        $sql = ' INSERT IGNORE INTO ' . tbl('email_variable') . ' (code, type, language_key) VALUES (\'type\',\'email\', \'email_variable_type\')';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'share_video_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{user_username}} wants to share a video with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
                  <tr>
                    <td bgcolor="#53baff" ><span class="title">{{website_title}}</span>share video</td>
                  </tr>
                  <tr>
                    <td height="20" class="messege">{{user_username}} wants to share Video With You
                      <div id="videoThumb"><a href="{{url}}"><img src="{{thumb_url}}"><br>
                    watch video</a></div></td>
                  </tr>
                  <tr>
                    <td class="text" ><span class="title2">Video Description</span><br>
                      <span class="text">{{message_subject}}</span></td>
                  </tr>
                  <tr>
                    <td><span class="title2">Personal Message</span><br>
                      <span class="text">{{message_content}}
                      </span><br>
                      <br>
                <span class="text">Thanks,</span><br> 
                <span class="text">{{user_username}}</span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#53baff">copyrights {{time}} {{website_title}}</td>
                  </tr>
                </table>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'photo_share_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{user_username}} wants to share a photo with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
                 <tr>
                      <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
                 </tr>
            
                 <tr>
                      <td height="20" class="messege">{{user_username}} wants to share this photo with you<br>
                           <div id="videoThumb"><a class="text" href="{{url}}"><img src="{{thumb_url}}"><br>
                      View Photo</a></div></td>
                 </tr>
                 <tr>
                      <td class="text" ><span class="title2">Photo Description</span><br>
                           <span class="text">{{message_subject}}</span></td>
                 </tr>
                 <tr>
                      <td><span class="title2">Personal Message</span><br>
                           <span class="text">{{message_content}}
                           </span><br>
                           <br>
                    <span class="text">Thanks,</span><br> 
                    <span class="text">{{website_title}}</span></td>
                 </tr>
                 <tr>
                      <td bgcolor="#0099cc">copyrights {{time}} {{website_title}}</td>
                 </tr>
            </table>\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'collection_share_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{user_username}} wants to share a collection with you\',
            \'<table width="100%" border="0" cellspacing="0" cellpadding="5">
             <tr>
                  <td bgcolor="#0099cc" ><span class="title">{{website_title}}</span></td>
             </tr>
        
             <tr>
                  <td height="20" class="messege">{{user_username}} wants to share this collection with you.<br>
                       <div id="videoThumb"><a class="text" href="{{url}}"><img src="{{thumb_url}}"><br>
                  View Collection <small class="text2">({{total_items}} {{type}})</small></a></div></td>
             </tr>
             <tr>
                  <td class="text" ><span class="title2">Collection Description</span><br>
                       <span class="text">{{message_subject}}</span></td>
             </tr>
             <tr>
                  <td><span class="title2">Personal Message</span><br>
                       <span class="text">{{message_content}}
                       </span><br>
                       <br>
                    <span class="text">Thanks,</span><br> 
                    <span class="text">{{website_title}}</span></td>
             </tr>
             <tr>
                  <td bgcolor="#0099cc">copyrights {{time}} {{website_title}}</td>
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

            <a href=\\\'{{url}}activation.php?av_username={{user_username}}&avcode={{code}}\\\'>Click Here</a>
            
            Email           : {{user_email}}
            Username        : {{user_username}}
            Activation code : {{code}}
            
            if above given is not working , please go here and activate it
            <a href=\\\'{{url}}activation.php\\\'>Activate</a>\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'pm_email_message\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{user_username}} has sent you a private message\',
            \'{{user_username}} has sent you a private message, 

                {{message_subject}}
                "{{message_content}}"
                
                click here to view your inbox <a href="{{url}}">Inbox</a>
                
                {{website_title}}\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'avcode_request_template\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] - {{user_username}} has sent you a private message\',
            \'Hello {{user_username}},
                
                Your Activation Code is : {{code}}
                <a   href=\\\'{{url}}activation.php?av_username={{user_username}}&avcode={{code}}\\\'>Click Here</a> To goto Activation Page
                
                Direct Activation
                ==========================================
                Click Here or Copy & Paste the following link in your browser
                {{url}}activation.php?av_username={{user_username}}&avcode={{code}}
                
                if above given links are not working, please go here and activate it
                
                Email           : {{user_email}}
                Username        : {{user_username}}
                Activation code : {{code}}
                
                if above given is not working , please go here and activate it
                <a  href=\\\'{{url}}activation.php\\\'>{{url}}activation.php</a>
                
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
            <a href="{{url}}">Reset my password</a>
            
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
                
                <a href="{{url}}">click here to login to website</a>
                
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
            \'[{{website_title}}] {{sender_name}} add you as friend\',
            \'Hi {{receiver_name}},
            {{sender_name}} added you as a friend on {{website_title}}. We need to confirm that you know {{sender_name}} in order for you to be friends on {{website_title}}.
            
            <a href="{{sender_link}}">View profile of {{sender_name}}</a> 
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
            \'[{{website_title}}] - {{sender_name}} has confirmed you as a friend\',
            \'Hi {{receiver_name}},
            {{sender_name}} confirmed you as a friend on {{website_title}}.
            
            <a href="{{sender_link}}">View {{sender_name}} profile</a>
            
            Thanks,
            The {{website_title}} Team\',
            FALSE
        )';
        self::query($sql);

        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'contact_form\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}} - Contact] {{message_subject}} from {{user_username}}\',
            \'Name : {{user_username}}
                Email : {{user_email}}
                Reason : {{message_subject}}
                
                Message:
                {{message_content}}
                
                <hr>
                Ip : {{url}}
                date : {{time}}\',
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
                {{url}}
                
                Thanks
                {{website_title}} Team\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_comment_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{user_username}} made comment on your {{message_subject}}\',
            \'{{user_username}} has commented on your {{message_subject}}
                "{{message_content}}"
                
                <a href="{{url}}">{{url}}</a>
                
                {{website_title}} team\',
            FALSE
        )';
        self::query($sql);
        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'user_reply_email\',
            ' . $inserted_template . ',
            FALSE,
            \'[{{website_title}}] {{user_username}} made reply on your comment\',
            \'{{user_username}} has replied on your comment
                "{{message_content}}"
                
                <a href="{{url}}">{{url}}</a>
                
                {{website_title}} team\',
            FALSE
        )';
        self::query($sql);


        $sql = 'INSERT IGNORE INTO ' . tbl('email') . ' (code, id_email_template, is_deletable, title, content, disabled) VALUE (
            \'video_subscription_email\',
            ' . $inserted_template . ',
            FALSE,
            \'{{sender_name}} has uploaded new video on {{website_title}}\',
            \'Hello {{user_username}}

                You have been notified by {{website_title}} that {{sender_name}} has uploaded new video 
                
                Video Title : {{message_subject}}
                Video Description : {{message_content}}
                
                
                <a href="{{url}}">
                <img src="{{thumb_url}}" border="0" height="90" width="120"><br>
                click here to watch this video</a>
                
                
                You are notified because you are subscribed to {{sender_name}}, you can manage your subscriptions by going to your account and click on manage subscriptions.
                {{website_title}}\',
            FALSE
        )';
        self::query($sql);

        self::generateTranslation('error_mail', [
            'fr'=>'Une erreur est survenue lors de l\'envoi du mail : %s',
            'en'=>'An error occurred during mail sending : %s'
        ]);
        self::updateTranslation('email_template', [
            'en'=>'Email template'
        ]);
    }
}
