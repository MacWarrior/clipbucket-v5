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
        self::generateTranslation('alert_update_core_already_ongoing', [
            'fr'=>'Une mise à jour du coeur est déjà en cours, doit-elle être marquée comme ayant échouée ?',
            'en'=>'A core update is already ongoing, should it be marked as failed ?'
        ]);

        self::generateTranslation('alert_update_db_already_ongoing', [
            'fr'=>'Une mise à jour de la base de donnée est en cours, doit-elle être marquée comme ayant échouée ?',
            'en'=>'A database upgrade is ongoing, should it be marked as failed ?'
        ]);

        self::generateTranslation('alert_video_conversion_ongoing', [
            'fr'=>'Une conversion vidéo est en cours, voulez-vous continuer la mise à jour ?',
            'en'=>'A video conversion is ongoing, do you want to continue update ?'
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}tools_histo_log` CHANGE `message` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL;',[
            'table'=>'tools_histo_log',
            'column'=>'message'
        ]);
    }

}
