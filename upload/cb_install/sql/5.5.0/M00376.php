<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00376 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('update_category', [
            'en' => 'Update category',
            'fr' => 'Mettre à jour la catégorie'
        ]);
        self::generateTranslation('add_new_category', [
            'en' => 'Add new category',
            'fr' => 'Ajouter une nouvelle catégorie'
        ]);
    }
}