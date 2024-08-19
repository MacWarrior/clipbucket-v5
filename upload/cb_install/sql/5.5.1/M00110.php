<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00110 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('remove_from_favorites', [
            'fr'=>'Retirer des favoris',
            'en'=>'Remove from favorites'
        ]);

        $sql = 'DROP TABLE IF EXISTS ' . tbl('video_favourites');
        self::query($sql);
    }
}