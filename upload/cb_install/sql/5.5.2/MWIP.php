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
        self::deleteConfig('enable_video_remote_upload');

        $translations = [
            'remote_upload',
            'remote_upload_example',
            'upload_data_now',
            'remoteDownloadStatusDiv',
            'upload_remote_video_msg',
            'remote_upload_file',
            'plugin_oxygenz_remote_play_remote_play',
            'plugin_oxygenz_remote_play_invalid_duration',
            'plugin_oxygenz_remote_play_form_head',
            'plugin_oxygenz_remote_play_input_url',
            'plugin_oxygenz_remote_play_input_url_example',
            'plugin_oxygenz_remote_play_checking',
            'plugin_oxygenz_remote_play_invalid_step',
            'plugin_oxygenz_remote_play_invalid_url',
            'plugin_oxygenz_remote_play_invalid_extension',
            'plugin_oxygenz_remote_play_website_not_responding',
            'plugin_oxygenz_remote_play_url_not_working',
            'plugin_oxygenz_remote_play_not_valid_video',
            'plugin_oxygenz_remote_play_saving',
            'plugin_oxygenz_remote_play_saving_error',
            'plugin_oxygenz_remote_play_video_saved'
        ];
        foreach($translations as $key) {
            self::deleteTranslation($key);
        }

        self::generateConfig('enable_video_remote_play', 'no');

        self::generateTranslation('option_enable_video_remote_play', [
            'fr' => 'Activer la lecture à distance',
            'en' => 'Enable remote play'
        ]);

        self::generateTranslation('remote_play', [
            'fr' => 'Lecture à distance',
            'en' => 'Remote play',
            'de' => 'Entfernte Wiedergabe',
            'pt-BR' => 'Reprodução remota'
        ]);

        self::generateTranslation('remote_play_input_url', [
            'fr' => 'URL du fichier vidéo',
            'en' => 'Video file URL'
        ]);

        self::generateTranslation('remote_play_input_url_example', [
            'fr' => 'e.g %s',
            'en' => 'e.g %s'
        ]);

        self::generateTranslation('remote_play_form_description', [
            'fr' => 'Ajoutez une vidéo par son URL ; le fichier vidéo ne sera pas télécharger mais juste lié',
            'en' => 'Add a video by it\'s URL ; video file won\'t be uploaded but just linked'
        ]);

        self::generateTranslation('remote_play_checking', [
            'fr' => 'Vérification du lien...',
            'en' => 'Checking link...'
        ]);

        self::generateTranslation('remote_play_saving', [
            'fr' => 'Sauvegarde de la vidéo...',
            'en' => 'Saving video...'
        ]);

        self::generateTranslation('remote_play_video_saved', [
            'fr' => 'La vidéo a été sauvegardée',
            'en' => 'Video has been saved'
        ]);

        self::generateTranslation('remote_play_saving_error', [
            'fr' => 'Vous ne pouvez mettre à jour que votre vidéo',
            'en' => 'You can only update your own video'
        ]);

        self::generateTranslation('remote_play_not_valid_video', [
            'fr' => 'Le fichier n\'est pas une vidéo valide',
            'en' => 'File isn\'t a valid video'
        ]);

        self::generateTranslation('remote_play_url_not_working', [
            'fr' => 'L\'URL indiquée ne fonctionne pas',
            'en' => 'Inputted URL is not working'
        ]);

        self::generateTranslation('remote_play_website_not_responding', [
            'fr' => 'Le site renseigné ne répond pas',
            'en' => 'Inputted website is not responding'
        ]);

        self::generateTranslation('remote_play_invalid_extension', [
            'fr' => 'L\'extension du fichier est invalide',
            'en' => 'File extension is invalid'
        ]);

        self::generateTranslation('remote_play_invalid_url', [
            'fr' => 'L\'URL fournie est invalide',
            'en' => 'URL provided is invalid'
        ]);

        self::generateTranslation('remote_play_invalid_step', [
            'fr' => 'Etape invalide',
            'en' => 'Invalid step'
        ]);

        self::generateTranslation('remote_play_invalid_duration', [
            'fr' => 'Durée invalide',
            'en' => 'Invalid duration',
            'de' => 'Ungültige Dauer',
            'pt-BR' => 'Duração inválida'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD `remote_play_url` TEXT NULL DEFAULT NULL',
            [
                'table' => 'video'
            ], [
                'table'  => 'video',
                'column' => 'remote_play_url',
            ]
        );
    }

}
