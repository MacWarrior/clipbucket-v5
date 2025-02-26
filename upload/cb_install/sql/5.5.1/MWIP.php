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
        self::alterTable('ALTER TABLE `' . tbl('video') . '` ADD COLUMN `convert_percent` FLOAT NULL DEFAULT 0;', [
            'table'  => 'video'
        ], [
            'table'  => 'video',
            'column' => 'convert_percent'
        ]);

        $sql = 'UPDATE `' . tbl('video') . '` SET `convert_percent` = 100 WHERE `status` = \'Successful\';';
        self::query($sql);

        self::generateTranslation('uploaded_by_x', [
            'fr'=>'Téléversé par by %s',
            'en'=>'Uploaded by %s'
        ]);

        self::generateTranslation('ongoing_conversion', [
            'fr'=>'Conversion en cours',
            'en'=>'Ongoing conversion'
        ]);

        self::deleteTranslation('this_vdo_not_working');

        /* Update revision IN :
         *
         * video.class.php : L.83 ; L.1038
         * video_convert.php : L.131
         * video_manager_line.html : L.79
         */
    }
}
