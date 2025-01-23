<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00247 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('this_user_blocked_you', [
            'fr' => 'Cet utilisateur vous a bloqué : %s',
            'en' => 'This user blocked you : %s'
        ]);

        self::generateTranslation('user_is_banned', [
            'fr'=>'Cet utilisateur est banni : %s',
            'en'=>'This user is banned : %s'
        ]);

        self::generateTranslation('you_cant_share_to_yourself', [
            'fr'=>'Vous ne pouvez pas faire de partage à vous même',
            'en'=>'You cannot share to yourself'
        ]);

        self::generateTranslation('link_this_photo', [
            'fr'=>'Lien de la photo',
            'en'=>'Link this photo'
        ]);

        self::generateTranslation('link_this_collection', [
            'fr'=>'Lien de la collection',
            'en'=>'Link this collection'
        ]);
    }
}