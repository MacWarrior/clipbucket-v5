INSERT IGNORE INTO `{tbl_prefix}config` (`name`, `value`)
    VALUES ('disable_email', 'no');

SET @language_id_eng = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'en');
SET @language_id_fra = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'fr');
SET @language_id_deu = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'de');
SET @language_id_por = (SELECT `language_id` FROM `{tbl_prefix}languages` WHERE language_code = 'pt-BR');

SET @language_key = 'disable_email' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Disable Emails', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Désactiver les emails', @language_id_fra);

SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` = 'signup_success_usr_ok');
UPDATE `{tbl_prefix}languages_translations` SET translation = 'Just One More Step' WHERE id_language_key = @id_language_key AND language_id = @language_id_eng;
UPDATE `{tbl_prefix}languages_translations` SET translation = 'Dernière étape' WHERE id_language_key = @id_language_key AND language_id = @language_id_fra;
UPDATE `{tbl_prefix}languages_translations` SET translation = 'Nur noch ein Schritt' WHERE id_language_key = @id_language_key AND language_id = @language_id_deu;
UPDATE `{tbl_prefix}languages_translations` SET translation = 'Apenas mais um passo' WHERE id_language_key = @id_language_key AND language_id = @language_id_por;

SET @language_key = 'signup_success_usr_ok_description' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Your are just one step behind from becoming an official member of our website.  Please check your email, we have sent you a confirmation email which contains a confirmation link from our website, Please click it to complete your registration.', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Un email de validation viens de vous être envoyé, il contient un lien permettant l\'activation définitive de votre compte.', @language_id_fra);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Sie sind nur noch einen Schritt davon entfernt, ein offizielles Mitglied unserer Website zu werden.  Bitte überprüfen Sie Ihre E-Mail, wir haben Ihnen eine Bestätigungs-E-Mail geschickt, die einen Bestätigungslink von unserer Website enthält. Bitte klicken Sie darauf, um Ihre Registrierung abzuschließen.', @language_id_deu);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Você é apenas um passo para trás de se tornar um meme oficial do nosso site. Por favor, verifique seu e-mail, enviamos um e-mail de confirmação que contém um link de confirmação do nosso site. Por favor, clique nele para completar o seu registro.', @language_id_por);

SET @language_key = 'signup_success_usr_ok_description_no_email' COLLATE utf8mb4_unicode_520_ci;
INSERT IGNORE INTO `{tbl_prefix}languages_keys` (`language_key`) VALUES (@language_key);
SET @id_language_key = (SELECT id_language_key FROM `{tbl_prefix}languages_keys` WHERE `language_key` COLLATE utf8mb4_unicode_520_ci = @language_key);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Emails have been disabled, please contact an administrator to manually enable your account.', @language_id_eng);
INSERT IGNORE INTO `{tbl_prefix}languages_translations` (`id_language_key`, `translation`, `language_id`)
    VALUES (@id_language_key, 'Les emails ont été désactivés, veuillez contacter un administrateur pour une activation manuelle de votre compte.', @language_id_fra);
