<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
require_once \DirPath::get('classes') . 'video_thumbs.class.php';
require_once \DirPath::get('classes') . 'update.class.php';

class MWIP extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $limit = 100;
        $offset = 0;
        $video_done = [];
        $thumbs = new \GlobIterator(\DirPath::get('thumbs') . '[0-9]*/[0-9]*/[0-9]*/*.*' );
        foreach ($thumbs as $thumb) {
            if (!in_array(pathinfo($thumb)['extension'], ['jpg', 'png', 'jpeg', 'gif'])) {
                continue;
            }
            $video_file_name = explode('-', pathinfo($thumb)['filename'])[0];
            if (in_array($video_file_name, $video_done)) {
                continue;
            }
            $video = \Video::getInstance()->getOne(['file_name' => $video_file_name]);
            if (!empty($video)) {
                $video_done[] = $video_file_name;
                $sql = 'UPDATE ' . tbl('video_image') . ' VI
                INNER JOIN ' . tbl('video_thumb') . ' VT ON VT.id_video_image = VI.id_video_image
                SET VT.version = \'' . $video['video_version'] . '\'
                WHERE videoid = ' . $video['videoid'] . ' AND type = \'thumbnail\'';
                self::query($sql);

                $sql_delete = 'DELETE vt_old
                    FROM ' . tbl(\VideoThumbs::getTableNameThumb()) . ' vt_old
                    JOIN ' . tbl(\VideoThumbs::getTableNameThumb()) . ' vt_new
                        ON vt_new.id_video_image = vt_old.id_video_image
                        AND vt_new.is_original_size = 1
                        AND vt_new.width != 0
                        AND vt_new.height != 0
                    WHERE vt_old.is_original_size = 1
                        AND (vt_old.width = 0 OR vt_old.height = 0)
                        AND vt_old.id_video_image IN (SELECT id_video_image FROM ' . tbl(\VideoThumbs::getTableName()) . ' WHERE videoid = ' . $video['videoid'] . ');';
                self::query($sql_delete);
            }

            if (count($video_done) >= $limit) {
                $video_done = [];
            }
        }

        $new_path = \DirPath::get('thumbs') . 'video';
        do {
            $videos_images = \VideoThumbs::getAllThumbs([
                'param_version_inf_or_eq' => '5.5.2',
                'limit'                   => $offset . ' , ' . $limit,
                'get_video_directory'     => true,
                'get_video_file_name'     => true,
                'get_num'                 => true,
                'get_is_auto'             => true,
                'get_type'                => true
            ]);
            foreach ($videos_images as $videos_image) {
                $path = $videos_image['file_directory'] . DIRECTORY_SEPARATOR . $videos_image['file_name'];
                if (!is_dir($new_path . DIRECTORY_SEPARATOR . $path)) {
                    mkdir($new_path . DIRECTORY_SEPARATOR . $path, 0777, true);
                }
                $resolution = $videos_image['is_original_size'] ? 'original' : '';
                $old_thumb = \DirPath::get('thumbs') . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], $videos_image['version']);
                if (!file_exists($old_thumb) && $videos_image['version'] <= '5.5.0') {
                    $old_thumb = \DirPath::get('thumbs') . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], 0);
                }

                if (rename($old_thumb
                    , $new_path . DIRECTORY_SEPARATOR . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], \Update::getInstance()->getCurrentCoreVersion())
                )) {
                    self::query('UPDATE ' . tbl(\VideoThumbs::getTableNameThumb()) . ' SET version = \'' . \Update::getInstance()->getCurrentCoreVersion() . '\' WHERE id_video_thumb = ' . $videos_image['id_video_thumb']);
                } else {
                    throw new \Exception('Error renaming ' . $old_thumb .
                        ' to ' . $new_path . DIRECTORY_SEPARATOR . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], \Update::getInstance()->getCurrentCoreVersion()));
                }
            }
        } while (!empty($videos_images));

        delete_empty_directories(\DirPath::get('thumbs'));
    }
}
