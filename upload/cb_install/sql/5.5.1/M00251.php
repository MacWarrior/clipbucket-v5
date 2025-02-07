<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00251 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        if (config('allowed_video_types') == 'wmv,avi,divx,3gp,mov,mpeg,mpg,xvid,flv,asf,rm,dat,mp4,mkv,webm') {
            self::updateConfig('allowed_video_types', 'wmv,avi,divx,3gp,mov,mpeg,mpg,xvid,flv,asf,rm,dat,mp4,mkv,webm,m4v,ts');
        }
    }
}
