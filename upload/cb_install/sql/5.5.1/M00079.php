<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00079 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'INSERT IGNORE INTO `{tbl_prefix}tools` (`language_key_label`, `language_key_description`, `function_name`, `code`) VALUES
            (\'correct_video_categorie_label\', \'correct_video_categorie_description\', \'AdminTool::correctVideoCategorie\', \'correct_video_categorie\')';
        self::query($sql);

        self::generateTranslation('correct_video_categorie_label', [
            'fr' => 'Correction des vidéos sans catégorie',
            'en' => 'Correct video categories'
        ]);
        self::generateTranslation('correct_video_categorie_description', [
            'fr'=>'Affecte la catégorie par défaut aux vidéos n\'ayant aucune catégorie',
            'en'=>'Link default categoy to videos without categories.'
        ]);
    }
}
