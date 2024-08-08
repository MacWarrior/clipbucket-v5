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
        self::generateTranslation('upload_poster', [
            'fr'=>'Téléverser une affiche',
            'en'=>'Upload a poster'
        ]);

        self::generateTranslation('upload_backdrop', [
            'fr'=>'Téléverser un décor',
            'en'=>'Upload a backdrop'
        ]);

        self::generateTranslation('poster_list', [
            'fr'=>'Liste des affiches',
            'en'=>'Poster list'
        ]);

        self::generateTranslation('backdrop_list', [
            'fr'=>'Liste des décors',
            'en'=>'Backdrop list'
        ]);
    }
}