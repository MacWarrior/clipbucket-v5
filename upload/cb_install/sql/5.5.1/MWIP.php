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

        self::generateTranslation('licence_modal_title', [
            'fr'=>'Clipbucket V5 est un logiciel libre sous %s.',
            'en'=>'ClipBucketV5 is an open-source software under %s.'
        ]);

        self::generateTranslation('licence_modal_legend', [
            'fr'=>'La license ClipBucketV5 a été mise jour à la version %s, révision %s',
            'en'=>'ClipBucketV5 license has been updated on version %s, revision %s :'
        ]);

        self::generateTranslation('accept_license', [
            'fr'=>'J\'accepte la nouvelle licence',
            'en'=>'I agree with new license'
        ]);
    }
}
