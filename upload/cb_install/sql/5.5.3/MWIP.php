<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD `id_tmdb` INT NULL;', [
            'table' => 'video'
        ], [
            'table'  => 'video',
            'column' => 'id_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD `type_tmdb` VARCHAR(255) NULL;', [
            'table' => 'video',
        ], [
            'table'  => 'video',
            'column' => 'type_tmdb'
        ]);

        self::insertTool('update_tmdb_info', 'AdminTool::updateTmdbInfo', '0 0 1 * *', true);

        self::generateTranslation('update_tmdb_info_label', [
            'fr'=>'Mise à jour des informations TMDB',
            'en'=>'Update TMDB info'
        ]);

        self::generateTranslation('update_tmdb_info_description', [
            'fr'=>'Met à jours les informations TMDB pour les vidéos ayant récupéré au moins une fois les informations TMDB',
            'en'=>'Update TMDB info for videos that gotten TMDB info at least once'
        ]);
    }
}

