<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00289 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('cannot_delete_not_empty_category', [
            'fr' => 'Vous ne pouvez pas supprimer une catégorie associée à des éléments',
            'en' => 'You cannot delete a category which is linked to an item'
        ]);

        self::generateTranslation('option_show_collapsed_checkboxes', [
            'fr' => 'Catégories repliables',
            'en' => 'Collapsible categories'
        ]);

        $thumbs = self::req('SELECT category_id, category_thumb FROM ' . tbl('categories') . ' WHERE TRIM(category_thumb) != \'\'');
        foreach ($thumbs as $thumb) {
            $ext = pathinfo($thumb['category_thumb'], PATHINFO_EXTENSION);
            self::query('UPDATE ' . tbl('categories') . ' SET category_thumb = \'' . $thumb['category_id'] . '.' . $ext . '\' 
            WHERE category_id = ' . (int)$thumb['category_id']);
        }
    }
}
