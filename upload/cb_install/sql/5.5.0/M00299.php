<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00299 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumbs` ADD COLUMN `type` VARCHAR(15) CHARACTER SET utf8 COLLATE utf8_general_ci;', [
            'table'  => 'video_thumbs'
        ], [
            'table'  => 'video_thumbs',
            'column' => 'type'
        ]);

        $sql = 'UPDATE `{tbl_prefix}video_thumbs` SET `type` = \'auto\' WHERE `type` IS NULL;';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumbs` ADD INDEX(`type`);', [
            'table'  => 'video_thumbs',
            'column' => 'type'
        ]);

        self::generateTranslation('extracted_thumbs', [
            'en' => 'Extracted thumbs',
            'fr' => 'Vignettes extraites'
        ]);

        self::generateTranslation('custom_thumbs', [
            'en' => 'Custom thumbs',
            'fr' => 'Vignettes personnalisées'
        ]);

        self::generateTranslation('upload_custom_thumbnail', [
            'en' => 'Upload custom thumbnail',
            'fr' => 'Téléverser une vignette personnalisée'
        ]);
    }
}