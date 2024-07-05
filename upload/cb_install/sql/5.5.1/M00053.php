<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00053 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('video_deleted', [
            'fr' => 'La vidéo a été supprimée',
            'en' => 'Video has been deleted'
        ]);
        self::generateTranslation('confirm_delete_video', [
            'fr' => 'Êtes vous certains de vouloir supprimer cette vidéo ?',
            'en' => 'Are you sure you want to delete this video ?'
        ]);

    }
}