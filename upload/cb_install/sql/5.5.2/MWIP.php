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
        self::updateTranslation('video_is_not_convertable', [
            'fr'=>'La vidéo %s ne peut pas être reconvertie',
            'en'=>'Video %s cannot be reconverted'
        ]);

        self::generateTranslation('video_is_already_waiting', [
            'fr'=>'La vidéo %s est déjà en attente de conversion',
            'en'=>'Video %s is already waiting for conversion'
        ]);

        self::updateTranslation('video_is_already_processing', [
            'fr'=>'La vidéo %s est déjà en cours de conversion',
            'en'=>'Video %s is already processing'
        ]);

        self::updateTranslation('reconversion_started_for_x', [
            'fr'=>'La reconversion de la vidéo %s a été lancée',
            'en'=>'Reconversion for video %s has been launched'
        ]);
    }
}
