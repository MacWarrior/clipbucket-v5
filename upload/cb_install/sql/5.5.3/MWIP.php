<?php

namespace V5_5_3;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateConfig('delete_video_on_delete_user', 'no');
       self::generateConfig('delete_collection_on_delete_user', 'no');
       self::generateConfig('delete_photo_on_delete_user', 'no');
       self::generateConfig('delete_playlist_on_delete_user', 'no');
       self::generateConfig('delete_comments_on_delete_user', 'no');

       self::generateTranslation('option_on_delete_user', [
           'fr'=>'Lors de la suppression d\'un utilisateur :',
           'en'=>'On deleting a user :'
       ]);

       self::generateTranslation('delete_user_s', [
           'fr'=>'Supprime les %s de l\'utilisateur',
           'en'=>'Delete user\'s %s'
       ]);
    }
}
