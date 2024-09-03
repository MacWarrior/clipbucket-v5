<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00124 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('text_confirm_comment', [
            'fr'=>'Êtes-vous sûr de vouloir supprimer ce commentaire ?',
            'en'=>'Are you sure you want to delete this comment ?'
        ]);

        self::generateTranslation('no_comments', [
            'fr'=>'Aucun commentaire pour cette %s'
        ]);
    }

}
