<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00336 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('error_server_config', [
            'en' => 'You must update <strong>"Server Configurations"</strong>. Click here <a href="%s">for details.</a>',
            'fr' => 'Merci de mettre à jour votre configuration serveur. Cliquez ici <a href="%s">pour plus d\'informations.</a >'
        ]);
        self::generateTranslation('not_required_version', [
            'en' => 'Current version of %s is <strong>%s</strong>, minimal version <strong>%s</strong> is required',
            'fr' => 'La version actuelle de %s est <strong>%s</strong>, la version minimale requise est <strong>%s</strong>'
        ]);
    }
}