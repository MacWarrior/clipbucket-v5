<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    public function __construct()
    {
        if (basename(__FILE__) !== 'MWIP.php') {
            parent::__construct();
        }
    }

    /**
     * @throws \Exception
     */
    public function start()
    {
        foreach (['email_template', 'email'] as $table) {
            self::alterTable('ALTER TABLE `{tbl_prefix}' . $table . '` ADD COLUMN `content_txt` TEXT DEFAULT \'\' AFTER `content`', [
                'table' => $table
            ], [
                'table'  => $table,
                'column' => 'content_txt'
            ]);
        }

        self::query('INSERT IGNORE INTO `{tbl_prefix}email_variable_link` (id_email, id_email_variable)
            SELECT email.id_email, email_variable.id_email_variable
            FROM `{tbl_prefix}email` AS email
            INNER JOIN `{tbl_prefix}email_variable` AS email_variable ON email_variable.code = \'video_title\'
            WHERE email.code = \'share_video\'');

        self::generateTranslation('email_content_html', [
            'fr' => 'Contenu HTML',
            'en' => 'HTML content'
        ]);
        self::generateTranslation('email_content_txt', [
            'fr' => 'Contenu texte brut',
            'en' => 'Plain-text content'
        ]);
        self::generateTranslation('email_content_txt_hint', [
            'fr' => 'Si aucun contenu texte brut n’est fourni pour l’e-mail, ClipBucket le génère automatiquement à l’envoi à partir du HTML.',
            'en' => 'If no plain-text content is provided for the email, ClipBucket generates it automatically from the HTML when sending.'
        ]);
        self::generateTranslation('email_content_required', [
            'fr' => 'Renseignez le contenu HTML ou le contenu texte brut.',
            'en' => 'Enter HTML or plain-text content.'
        ]);
        self::generateTranslation('email_content_variable_required', [
            'fr' => 'Le champ « %s » doit contenir la variable %s.',
            'en' => 'The “%s” field must contain the %s variable.'
        ]);
    }
}
