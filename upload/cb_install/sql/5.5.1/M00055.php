<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00055 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
       self::generateTranslation('cancel_uploading', [
           'fr'=>'Annuler le téléversement',
           'en'=>'Cancel uploading'
       ]);
       self::generateTranslation('upload_more_videos', [
           'fr'=>'Téléverser plus de vidéos'
       ]);
       self::generateTranslation('pourcent_completed', [
           'fr'=>'% complété',
           'en'=>'% completed'
       ]);
       self::generateTranslation('submit_now', [
           'fr'=>'Enregistrer',
       ]);
    }
}