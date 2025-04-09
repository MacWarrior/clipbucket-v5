<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00329 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE ' . tbl('video') . ' ADD COLUMN `aspect_ratio` DECIMAL(10,6) NULL DEFAULT NULL',
            [
                'table'  => 'video'
            ], [
                'table'  => 'video',
                'column' => 'aspect_ratio'
            ]
        );

        self::insertTool('update_aspect_ratio', 'AdminTool::updateAspectRatio', null, true);
        self::generateTranslation('update_aspect_ratio_label', [
            'fr'=>'Mise à jour des ratios de vidéo manquants',
            'en'=>'Update missing video aspect ratio'
        ]);

        self::generateTranslation('update_aspect_ratio_description', [
            'fr'=>'Met à jour les ratios manquants des vidéos, en se basant sur les fichiers vidéo',
            'en'=>'Update missing video aspect ratio, based on video files'
        ]);
    }
}
