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

        $new_path = \DirPath::get('thumbs') . 'video';
        do {
            $videos = \Clipbucket_db::getInstance()->_select('SELECT * FROM ' . tbl('video') . ' LIMIT ' . $offset . ' , ' . $limit);
            foreach ($videos as $video) {
                $changed_poster = false;
                $changed_backdrop = false;
                $sql = ' SELECT VI.*, VT.extension, VT.is_original_size, VT.width, VT.height FROM ' . tbl('video_image') . ' VI
                     LEFT JOIN ' . tbl('video_thumb') . ' VT ON VT.id_video_image = VI.id_video_image
                    WHERE (VI.type = \'poster\' OR VI.type = \'backdrop\')
                    AND (SELECT COUNT(*) FROM ' . tbl('video_thumb') . ' WHERE id_video_image = VI.id_video_image) = 1
                    AND VI.videoid = ' . (int)$video['videoid'];
                $videos_images = \Clipbucket_db::getInstance()->_select($sql);

                foreach ($videos_images as $videos_image) {
                    if ($videos_image['type'] == 'poster') {
                        $changed_poster = true;
                    } elseif ($videos_image['type'] == 'backdrop') {
                        $changed_backdrop = true;
                    }
                    $resolution = $videos_image['is_original_size'] ? 'original' : '';
                    $video_thumbs = new \VideoThumbs($videos_image['videoid']);
                    $video_thumbs->prepareFFmpeg();
                    //check mime extension
                    $file = $new_path . DIRECTORY_SEPARATOR . \VideoThumbs::getThumbPath($videos_image['type'], $video['file_directory'], $video['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], \Update::getInstance()->getCurrentCoreVersion());
                    $extension = $videos_image['extension'];
                    if (file_exists($file)) {
                        $extension = getExtMimeType($file);
                        if ($extension != $videos_image['extension']) {
                            $new_file = str_replace($videos_image['extension'], $extension, $file);
                            rename($file, $new_file);
                        }
                    }
                    if (!empty($new_file)) {
                        $file = $new_file;
                    }

                    \VideoThumbs::uploadThumbs($video['videoid'], [
                        'tmp_name' => [$file],
                        'name'     => [\VideoThumbs::getThumbName($videos_image['type'], $video['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $extension, \Update::getInstance()->getCurrentCoreVersion())]
                    ], $videos_image['type'], true);

                    //delete old video_image & thumbs
                    $sql = 'DELETE FROM ' . tbl('video_thumb') . ' WHERE id_video_image = ' . (int)$videos_image['id_video_image'];
                    self::query($sql);
                    $sql = 'DELETE FROM ' . tbl('video_image') . ' WHERE id_video_image = ' . (int)$videos_image['id_video_image'];
                    self::query($sql);
                }
                if ($changed_poster) {
                    \Video::getInstance()->resetDefaultPicture($video['videoid'], 'poster');
                }
                if ($changed_backdrop) {
                    \Video::getInstance()->resetDefaultPicture($video['videoid'], 'backdrop');
                }
                $offset += $limit;
            }

        } while (!empty($videos));

    }
}
