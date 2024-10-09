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
        self::deleteConfig('baseurl');

        self::updateTranslation('website_configuration_info', [
            'en' => 'Here you can set basic configuration of your website, you can change them later by going to Admin area > Configurations',
            'fr' => 'Vous pouvez paramétrer ici des éléments de base, vous pourrez les changer ultérieurement en allant dans l\'espace d\'administration > Configurations'
        ]);

        self::generateConfig('license_validation', '');
    }
}
