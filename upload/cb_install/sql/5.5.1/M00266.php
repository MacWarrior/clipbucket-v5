<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00266 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateConfig('enable_country_video_field', 'yes');
        self::generateConfig('enable_location_video_field', 'yes');
        self::generateConfig('enable_recorded_date_video_field', 'yes');

        self::generateTranslation('enable_country_video_field', [
            'fr'=>'Activer le champs Pays',
            'en'=>'Enable Country field'
        ]);
        self::generateTranslation('enable_location_video_field', [
            'fr'=>'Activer le champs Localisation',
            'en'=>'Enable Location field'
        ]);
        self::generateTranslation('enable_recorded_date_video_field', [
            'fr'=>'Activer le champs Date',
            'en'=>'Enable Recorded Date field'
        ]);
    }
}
