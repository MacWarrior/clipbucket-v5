<?php
namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00185 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('wip_done', [
            'fr'=>'Migration WIP effectuée avec succès',
            'en'=>'WIP migration done succesfully'
        ]);
        self::generateTranslation('relaunch', [
            'fr'=>'Relancer',
            'en'=>'Relaunch'
        ]);

        self::generateConfig('enable_hide_uploader_name', 'no');

        self::generateTranslation('option_enable_hide_uploader_name', [
            'fr' => 'Masquer le nom du propriétaire',
            'en' => 'Hide uploader\'s name'
        ]);

        self::generateTranslation('tips_enable_hide_uploader_name', [
            'fr' => 'Si activé, les nom de propriétaires sont masqués',
            'en' => 'When enabled, uploader\'s name will be hidden'
        ]);
    }
}