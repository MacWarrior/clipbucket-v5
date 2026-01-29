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
        self::generateTranslation('you_cant_rate_own_photo', [
            'fr'=>'	Vous ne pouvez voter pour vos propres photos',
            'en' => 'You can\'t rate your own photo'
        ]);

        self::generateTranslation('you_cant_rate_own_collection', [
            'fr'=>'Vous ne pouvez pas voter pour vos propres collections',
            'en' => 'You can\'t rate your own collection'
        ]);

        self::generateTranslation('collection_rate_disabled', [
            'fr'=>'Le vote des collections est désactivé',
            'en'=>'Collection rating is disabled'
        ]);

        self::generateTranslation('channel_rate_disabled', [
            'fr'=>'Le vote des chaines est désactivé',
            'en'=>'Channel rating is disabled'
        ]);

        self::generateTranslation('you_cant_rate_own_channel', [
            'fr'=>'Vous ne pouvez pas voter pour votre propre chaine',
        ]);

        self::generateTranslation('vid_rate_disabled', [
            'fr'=>'Le vote des vidéos est désactivé'
        ]);
    }
}
