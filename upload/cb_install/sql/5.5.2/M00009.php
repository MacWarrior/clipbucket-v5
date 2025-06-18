<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00009 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('nginx_vhost', [
            'fr'=>'VirtualHost Nginx',
            'en'=>'Nginx VirtualHost'
        ]);
        self::generateTranslation('nginx_vhost_desc', [
            'fr'=>'Voici la configuration de base du VirtualHost pour ClipBucketV5 sur Nginx :',
            'en'=>'Here\'s the basic VirtualHost setup for ClipBucketV5 on Nginx:'
        ]);
        self::generateTranslation('nginx_vhost_last_updated', [
            'fr'=>'Le VirtualHost de base a été mis à jour pour la dernière fois dans la version %s',
            'en'=>'The basic VirtualHost was last updated in version %s'
        ]);
        self::generateTranslation('nginx_vhost_first_update', [
            'fr'=>'Il semble que ce soit votre premier contrôle du VirtualHost. Veuillez vous assurer qu\'il est à jour',
            'en'=>'This seems to be your first VirtualHost check. Please make sure it\'s up to date.'
        ]);
        self::generateTranslation('nginx_vhost_no_update', [
            'fr'=>'Aucune nouvelle version du VirtualHost n\'a été publiée depuis votre dernière mise à jour %s',
            'en'=>'No new VirtualHost version has been released since your last update %s'
        ]);
        self::generateTranslation('nginx_vhost_update', [
            'fr'=>'Il semble que vous ayez mis à jour votre VirtualHost pour la dernière fois en version %s',
            'en'=>'It looks like you last updated your VirtualHost in version %s'
        ]);
        self::generateTranslation('nginx_vhost_updated', [
            'fr'=>'Mon VirtualHost est à jour !',
            'en'=>'My VirtualHost is up-to-date !'
        ]);

        self::generateConfig('nginx_vhost_version','');
        self::generateConfig('nginx_vhost_revision','');
    }
}
