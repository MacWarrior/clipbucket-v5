<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('confirmation_upgrade_core_php_version_require', [
            'fr' => 'Votre version PHP actuelle (%s) n’est pas supportée par la mise à jour ciblée (%s). La mise à jour vers cette version pourrait endommager votre site web ; êtes-vous sûr de vouloir effectuer la mise à jour ?',
            'en' => 'Your current PHP version (%s) isn’t supported with targeted update (%s). Updating to this version may break your website ; are you sure you want to update ?'
        ]);

    }

}
