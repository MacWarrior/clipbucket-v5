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
       self::generateTranslation('channel_doesnt_exists', [
           'fr'=>'La chaîne n\'existe pas',
           'en'=>'Channel doesn\'t'
       ]);

       self::generateTranslation('user_has_been_set_as_featured', [
           'fr'=>'L\'utilisateur est marqué en vedette',
           'en'=>'User has been set as featured'
       ]);

       self::generateTranslation('user_has_been_removed_from_featured_users', [
           'fr'=>'L\'utilisateur a été retiré des vedettes',
           'en'=>'User has been removed from featured users'
       ]);

       self::generateTranslation('cant_featured_deactivate_user', [
           'fr'=>'Vous ne pouvez pas marquer une chaîne désactivée en vedette',
           'en'=>'You cannot tag a deactivated channel as featured'
       ]);

       self::generateTranslation('cannot_access_page', [
           'fr'=>'Vous ne pouvez pas accéder à cette page',
           'en'=>'You cannot access this page'
       ]);
    }
}
