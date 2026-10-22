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
        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}collection_thumb` (
            `id_collection_thumb` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `collection_id` BIGINT(25) NOT NULL,
            `width` INT NOT NULL,
            `extension` VARCHAR(4) NOT NULL,
            `version` VARCHAR(16) NOT NULL,
            `is_original_size` BOOL DEFAULT FALSE NOT NULL,
            UNIQUE KEY (`collection_id`, `width`)
        )';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}collection_thumb` ADD CONSTRAINT `collection_thumb_ibfk_1` FOREIGN KEY (collection_id) REFERENCES `{tbl_prefix}collections` (collection_id) ON DELETE NO ACTION ON UPDATE NO ACTION;', [
            'table'  => 'collections',
            'column' => 'collection_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'collection_thumb_ibfk_1'
            ]
        ]);

        self::generateTranslation('collection_delete_successfully', [
            'fr'=>'La collection a été supprimée avec succès',
            'en'=>'The collection has been deleted successfully'
        ]);
    }
}
