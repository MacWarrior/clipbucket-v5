<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00286 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {

        self::generateTranslation('mass_category_selection', [
            'fr'=>'Sélection des categories en masse',
            'en'=>'Mass category selection'
        ]);

        self::generateTranslation('mass_broadcast_selection', [
            'fr'=>'Sélection de diffusion en masse',
            'en'=>'Mass broadcast selection'
        ]);

        self::generateTranslation('vdo_br_opt1', [
            'fr'=>'Publique - Partagez votre vidéo avec tout le monde! (Recommandé)'
        ]);

        self::generateTranslation('vdo_br_opt2', [
            'fr'=>'Privé - Visible uniquement par vous et vos amis'
        ]);

        self::generateTranslation('vdo_broadcast_unlisted', [
            'fr'=>'Non listé (visible par quiconque avec le lien et/ou le mot de passe)'
        ]);

        self::generateTranslation('logged_users_only', [
            'fr'=>'Connecté seulement (visible uniquement par les utilisateurs connectés)'
        ]);
    }
}
