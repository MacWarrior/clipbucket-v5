<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00004 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::deleteTranslation('grp_view_vdos');

        $sql = 'UPDATE `' . tbl('config') . '` SET value = \'images/icons/player-logo.png\' WHERE value = \'/images/icons/player-logo.png\' AND name = \'control_bar_logo_url\';';
        self::query($sql);

        self::generateTranslation('directory_x_is_forbidden', [
            'fr'=>'Le sous-dossier utilisé "%s" est réservé par le système et ne peut pas être utilisé pour héberger le site. Veuillez en choisir un autre pour assurer le bon fonctionnement de la plateforme.',
            'en'=>'The subdirectory "%s" is reserved by the system and cannot be used to host the site. Please choose a different one to ensure proper platform functionality.'
        ]);
    }
}
