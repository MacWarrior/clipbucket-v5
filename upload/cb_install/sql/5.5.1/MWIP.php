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
        self::generateConfig('enable_social_networks_links', 'yes');

        self::generateTranslation('option_enable_social_networks_links', [
            'fr' => 'Activer les liens de réseaux sociaux',
            'en' => 'Enable social networks links'
        ]);
        self::generateTranslation('manage_social_networks_links', [
            'fr' => 'Gestion des liens des réseaux sociaux',
            'en' => 'Manage social networks links'
        ]);
        self::generateTranslation('add_new_social_network_link', [
            'fr' => 'Ajouter un nouveau lien de réseau social',
            'en' => 'Add new social network link'
        ]);
    }
}
