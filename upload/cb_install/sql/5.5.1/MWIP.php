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

       self::generateTranslation('cannot_delete_not_empty_category', [
           'fr'=>'Vous ne pouvez pas supprimer une catégorie associée à des éléments',
           'en'=>'You cannot delete a category which is linked to an item'
       ]);

       self::generateTranslation('option_show_collapsed_checkboxes', [
           'fr'=>'Catégories repliables',
           'en'=>'Collapsible categories'
       ]);
    }
}
