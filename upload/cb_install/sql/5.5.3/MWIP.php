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
        self::alterTable('CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_tmdb` (
            video_id BIGINT(20) NOT NULL PRIMARY KEY,
            tmdb_id INT NOT NULL,
            tmdb_type VARCHAR(255) NOT NULL,
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;', [], [
            'table' => 'video_tmdb'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_tmdb` ADD CONSTRAINT `tmdb_video_ibfk_1` FOREIGN KEY (`video_id`) REFERENCES `{tbl_prefix}video` (`videoid`) ON DELETE NO ACTION ON UPDATE NO ACTION ;', [
            'table'  => 'video_tmdb',
            'column' => 'video_id'
        ], [
                'constraint' => [
                    'type' => 'FOREIGN KEY',
                    'name' => 'tmdb_video_ibfk_1'
                ]
            ]
        );

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `external_rate` FLOAT NOT NULL DEFAULT 0', [
            'table' => 'video'
        ], [
            'table'  => 'video',
            'column' => 'external_rate'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `external_ratings` INT NOT NULL DEFAULT 0', [
            'table' => 'video'
        ], [
            'table'  => 'video',
            'column' => 'external_ratings'
        ]);

        $limit = 100;
        $offset = 0;
        do {
            $videos = \Video::getInstance()->getAll([
                'limit'     => $offset . ' , ' . $limit,
                'condition' => 'id_tmdb IS NOT NULL'
            ]);
            $offset += $limit;
            foreach ($videos as $video) {
                $sql = 'INSERT INTO ' . tbl('video_tmdb') . ' (video_id, tmdb_type, tmdb_id) VALUES ( ' . (int)$video['videoid'] . ', \'' . $video['type_tmdb'] . '\', ' . (int)$video['id_tmdb'] . ')
                    ON DUPLICATE KEY UPDATE tmdb_id = VALUES(tmdb_id), tmdb_type = VALUES(tmdb_type)';
                \Clipbucket_db::getInstance()->execute($sql);
            }
        } while (!empty($videos));
        
        self::generateConfig('enable_external_rate_field', 'no');
        self::generateConfig('enable_external_ratings_field', 'no');
        self::generateConfig('enable_external_rate_ratings_on_fo', 'no');
        self::generateConfig('enable_external_rate_from_tmdb', 'no');
        self::generateConfig('enable_external_ratings_from_tmdb', 'no');

        self::generateTranslation('option_enable_external_rate_field', [
            'fr'=>'Activer le champ de notation',
            'en'=>'Enable external rate field'
        ]);
        self::generateTranslation('option_enable_external_ratings_field', [
            'fr'=>'Activer le champ de nombre de notes',
            'en'=>'Enable external ratings field'
        ]);
        self::generateTranslation('option_enable_external_rate_ratings_on_fo', [
            'fr'=>'Activer l\'édition de notation sur le front office',
            'en'=>'Enable external rate & external ratings edition on front end'
        ]);
        self::generateTranslation('option_enable_external_rate_from_tmdb', [
            'fr'=>'Activer la notation depuis TMDB',
            'en'=>'Enable external rate from TMDB'
        ]);
        self::generateTranslation('option_enable_external_ratings_from_tmdb', [
            'fr'=>'Activer le nombre de notes depuis TMDB',
            'en'=>'Enable external ratings from TMDB'
        ]);
        self::generateTranslation('external_rate', [
            'fr' => 'Note externe',
            'en' => 'external rate'
        ]);
        self::generateTranslation('external_ratings', [
            'fr' => 'Nombre de notes de externe',
            'en' => 'external ratings'
        ]);
        self::generateTranslation('please_enter_val_bigger_than_min', [
            'fr'=>'Le champs %s doit avoir une valeur supérieure à \'%s\'',
            'en'=>'Please enter \'%s\' value superior to \'%s\''
        ]);
        self::generateTranslation('please_enter_val_smaller_than_max', [
            'fr'=>'Le champs %s doit avoir une valeur inférieure à \'%s\'',
            'en'=>'Please enter \'%s\' value inferior to \'%s\''
        ]);
        self::generateTranslation('external_video_rate', [
            'fr'=>'Note externe de la vidéo, de 0 à 10',
            'en'=>'External video rate from 0 to 10'
        ]);
        self::generateTranslation('external_video_ratings', [
            'fr'=>'Nombre de votes pour la note externe',
            'en'=>'Number of votes for external video rate'
        ]);
    }
}
