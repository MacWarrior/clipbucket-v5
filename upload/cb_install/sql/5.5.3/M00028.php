<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00028 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('you_cant_rate_own_photo', [
            'fr' => 'Vous ne pouvez voter pour vos propres photos',
            'en' => 'You can\'t rate your own photo'
        ]);

        self::generateTranslation('you_cant_rate_own_collection', [
            'fr' => 'Vous ne pouvez pas voter pour vos propres collections',
            'en' => 'You can\'t rate your own collection'
        ]);

        self::generateTranslation('collection_rate_disabled', [
            'fr' => 'Le vote des collections est désactivé',
            'en' => 'Collection rating is disabled'
        ]);

        self::generateTranslation('channel_rate_disabled', [
            'fr' => 'Le vote des chaines est désactivé',
            'en' => 'Channel rating is disabled'
        ]);

        self::generateTranslation('you_cant_rate_own_channel', [
            'fr' => 'Vous ne pouvez pas voter pour votre propre chaine',
        ]);

        self::generateTranslation('vid_rate_disabled', [
            'fr' => 'Le vote des vidéos est désactivé'
        ]);

        self::updateConfig('own_collection_rating', config('own_collection_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('collection_rating', config('collection_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('own_channel_rating', config('own_channel_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('channel_rating', config('channel_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('own_video_rating', config('own_video_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('video_rating', config('video_rating') === '1' ? 'yes' : 'no');
        self::updateConfig('comment_rating', config('comment_rating') === '1' ? 'yes' : 'no');
    }
}
