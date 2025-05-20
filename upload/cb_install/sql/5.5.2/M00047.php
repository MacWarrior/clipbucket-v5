<?php

namespace V5_5_2;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00047 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        self::generateTranslation('resume_conversion', [
            'fr'=>'Reprendre la conversion',
            'en'=>'Resume conversion'
        ]);
        self::generateTranslation('selected_conversion_resumed', [
            'fr'=>'Les conversions sélectionnées ont été reprises',
            'en'=>'Selected conversions have been resumed'
        ]);
        self::generateTranslation('conversion_not_found_x', [
            'fr'=>'Impossible de trouver la conversion %s',
            'en'=>'Conversion %s can\'t be found'
        ]);
        self::generateTranslation('video_not_found_with_filename_x', [
            'fr'=>'Impossible de trouver la vidéo du fichier %s',
            'en'=>'No video found with filename %s'
        ]);
        self::generateTranslation('conversion_x_cannot_be_resumed', [
            'fr'=>'La conversion de la vidéo "%s" ne peut reprendre à cause de son statut',
            'en'=>'Video "%s\" conversion can\'t be resumed because of it\'s status'
        ]);
        self::generateTranslation('conversion_queue_warning', [
            'fr'=>'Ceci est une page de configuration avancée. Veuillez vous assurer de bien comprendre les modifications que vous effectuez. Des actions incorrectes peuvent perturber ou casser les conversions vidéo en cours.',
            'en'=>'This is an advanced configuration page. Please make sure you fully understand the changes you are making. Incorrect actions may disrupt or break video ongoing conversions.'
        ]);
    }
}
