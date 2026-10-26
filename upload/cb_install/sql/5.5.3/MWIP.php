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
        self::query("CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_image` (
            id_collection_image INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            collection_id BIGINT(25) NOT NULL,
            type ENUM('thumbnail', 'poster', 'backdrop') NOT NULL,
            num INT NOT NULL,
            is_auto BOOL DEFAULT TRUE NOT NULL,
            UNIQUE KEY (collection_id, type, num, is_auto)
        )");
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_image` ADD CONSTRAINT `collection_image_ibfk_1` FOREIGN KEY (collection_id) REFERENCES `{tbl_prefix}collections` (collection_id)', [
            'table'  => 'collections',
            'column' => 'collection_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'collection_image_ibfk_1'
            ]
        ]);


        self::query('CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_thumb` (
            id_collection_thumb INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_collection_image INT NOT NULL,
            width INT NOT NULL,
            height INT NOT NULL,
            extension VARCHAR(4) NOT NULL,
            version VARCHAR(16) NOT NULL,
            is_original_size BOOL DEFAULT FALSE NOT NULL,
            UNIQUE KEY `collection_image_resolution` (id_collection_image, width, height, is_original_size)
        )');
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_thumb` ADD CONSTRAINT `collection_thumb_image_ibfk_1` FOREIGN KEY (id_collection_image) REFERENCES `{tbl_prefix}collection_image` (id_collection_image)', [
            'table'  => 'collection_image',
            'column' => 'id_collection_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'collection_thumb_image_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD COLUMN `default_thumbnail` INT NULL', [
            'table' => 'collections'
        ], [
            'table'  => 'collections',
            'column' => 'default_thumbnail'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}collections` ADD CONSTRAINT `collection_default_thumb_ibfk_1` FOREIGN KEY (default_thumbnail) REFERENCES `{tbl_prefix}collection_image` (id_collection_image) ON DELETE SET NULL', [
            'table'  => 'collection_image',
            'column' => 'id_collection_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'collection_default_thumb_ibfk_1'
            ]
        ]);

        self::generateConfig('enable_collection_poster', 'no');
        self::generateConfig('enable_collection_backdrop', 'no');
        self::generateConfig('collection_tmdb_get_backdrop', 'no');
        self::generateConfig('collection_tmdb_get_poster', 'no');
        self::generateTranslation('option_enable_collection_poster', [
            'fr'=>'Activer les affiches pour les collections',
            'en'=>'Enable collection posters'
        ]);
        self::generateTranslation('option_enable_collection_backdrop', [
            'fr'=>'Activer les décors pour les collections',
            'en'=>'Enable collection backdrops'
        ]);

        self::generateTranslation('collection_delete_successfully', [
            'fr' => 'La collection a été supprimée avec succès',
            'en' => 'The collection has been deleted successfully'
        ]);
    }
}
