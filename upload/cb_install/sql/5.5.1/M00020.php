<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00020 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_tmdb_mature_content', 'no');
        self::generateConfig('tmdb_mature_content_age', '18');

        self::generateTranslation('enable_tmdb_mature_content', [
            'en' => 'Enable mature content',
            'fr' => 'Activer le contenu mature'
        ]);
        self::generateTranslation('tmdb_mature_content_age', [
            'en' => 'Minimal age for adult content',
            'fr' => 'Âge minimum du contenu pour adulte'
        ]);
        self::generateTranslation('access_forbidden_under_age_display', [
            'en' => '- %s',
            'fr' => '- %s'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}tmdb_search_result` ADD COLUMN `is_adult` BOOLEAN', [
            'table'  => 'tmdb_search_result'
        ], [
            'table'  => 'tmdb_search_result',
            'column' => 'is_adult'
        ]);
    }
}