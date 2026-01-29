<?php

namespace V5_5_3;
use VideoThumbs;

require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = '
            SELECT V.* FROM ' . tbl('video') . ' V
            INNER JOIN ' . tbl('video_image') .' VI ON VI.videoid = V.videoid 
            INNER JOIN ' . tbl('video_thumb') .' VT ON VT.id_video_image  = VI.id_video_image  
            WHERE VT.version < \'5.5.3\'
            GROUP BY V.videoid';
        $videos = self::req($sql);

        foreach ($videos as $video) {
            $video_thumb = new VideoThumbs($video['videoid']);
            $video_thumb->importOldThumbFromDisk(true);
        }
    }
}
