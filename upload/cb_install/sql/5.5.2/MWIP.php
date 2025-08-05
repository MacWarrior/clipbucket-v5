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

        $translations = ['remote_upload', 'remote_upload_example', 'upload_data_now', 'remoteDownloadStatusDiv', 'upload_remote_video_msg', 'remote_upload_file'];
        foreach($translations as $key) {
            self::deleteTranslation($key);
        }
    }

}
