<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        self::generateTranslation('cant_perform_action_until_app_fully_updated', [
            'fr'=>'Désolé, vous ne pouvez pas effectuer cette action tant que l\'application ne sera pas mise à jour par un administrateur.',
            'en'=>'Sorry, you cannot perform this action until the application has been fully updated by an administrator.'
        ]);

        $sql = 'UPDATE {tbl_prefix}email SET title = \'[{{website_title}}] Friend request from {{sender_username}}\' WHERE code=\'friend_request\'';
        self::query($sql);
    }
}
