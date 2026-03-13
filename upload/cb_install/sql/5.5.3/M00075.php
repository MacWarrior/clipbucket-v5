<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
require_once \DirPath::get('classes') . 'video_thumbs.class.php';
require_once \DirPath::get('classes') . 'update.class.php';

class M00075 extends \Migration
{
    /**
     * @throws \Exception
     */
    private static function importOldThumbFromDisk($video): void
    {
        $logFile = \DirPath::get('logs') . $video['file_directory'] . DIRECTORY_SEPARATOR . $video['file_name'] . '.log';
        $log = new \SLog($logFile);
        $ffmpeg_instance = new \FFMpeg($log);
        $vid_file = get_high_res_file($video);
        $ffmpeg_instance->input_details['duration'] = $video['duration'];
        $ffmpeg_instance->input_file = $vid_file;
        $ffmpeg_instance->file_directory = $video['file_directory'] . DIRECTORY_SEPARATOR;
        $ffmpeg_instance->file_name = $video['file_name'];
        $ffmpeg_instance->prepare();
        //check files
        $glob = \DirPath::get('thumbs') . $ffmpeg_instance->file_directory . $ffmpeg_instance->file_name . '*';
        $vid_thumbs = glob($glob);
        if (!empty($vid_thumbs) && !empty($video['file_directory']) && !empty($video['file_name'])) {
            foreach ($vid_thumbs as $thumb) {
                $files_info = [];
                //pattern must match :  /`file_name`-`size`-`num`.`extension`
                preg_match('/\/\w*-(\w{1,16})-(\d{1,4})\.(\w{2,4})$/', $thumb, $files_info);
                if (!empty($files_info)) {
                    if (\Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
                        $sql = 'SELECT id_video_image FROM ' . tbl('video_image') . ' WHERE videoid = ' . $video['videoid'] . ' AND type = \'thumbnail\' AND num = ' . (int)$files_info[2];
                        $video_image = \Clipbucket_db::getInstance()->_select($sql)[0];
                        $num = (int)$files_info[2];
                        if (empty($video_image)) {
                            $id_video_image = \Clipbucket_db::getInstance()->insert(tbl('video_image'), [
                                'videoid',
                                'type',
                                'num'
                            ], [
                                $video['videoid'],
                                'thumbnail',
                                $num
                            ]);
                        } else {
                            $id_video_image = $video_image['id_video_image'];
                        }


                        $sql = ' UPDATE ' . tbl('video_thumb') . ' SET version =  \'' . ($video['video_version'] <= '5.5.2' ? $video['video_version'] : '5.5.2') . '\'
                         WHERE id_video_image = ' . $id_video_image . ' 
                         AND ';

                        if ($files_info[1] == 'original') {
                            $sql .= ' is_original_size = 1 ';
                        } else {
                            $sizes = \VideoThumbs::getWidthHeightFromSize($files_info[1]);
                            $sql .= ' width = ' . (int)$sizes['width'] . ' AND height = ' . (int)$sizes['height'] . ' ';
                        }
                        if ($num == 0) {
                            $sql_insert = ' INSERT IGNORE INTO ' . tbl('video_thumb') . ' (`id_video_image`,
                            `width`,
                            `height`,
                            `extension`,
                            `version`,
                            `is_original_size`) VALUES (
                            ' . $id_video_image . ',
                            ' . ($sizes['width'] ?? 0) . ',
                            ' . ($sizes['height'] ?? 0) . ',
                            \'' . $files_info[3] . '\',
                            \'' . ($video['video_version'] <= '5.5.2' ? $video['video_version'] : '5.5.2') . '\',
                            ' . (int)($files_info[1] == 'original') . ' )';
                            self::query($sql_insert);
                        }
                        self::query($sql);
                    }
                }
            }
        }
    }

    /**
     * @throws \Exception
     */
    public function start()
    {
        $limit = 100;
        $offset = 0;
        $video_done = [];
        $thumbs = new \GlobIterator(\DirPath::get('thumbs') . '[0-9]*/[0-9]*/[0-9]*/*.*');
        foreach ($thumbs as $thumb) {
            if (!in_array(pathinfo($thumb)['extension'], ['jpg', 'png', 'jpeg', 'gif'])) {
                continue;
            }
            if (filesize($thumb) == 0) {
                unlink($thumb);
                continue;
            }
            $video_file_name = explode('-', pathinfo($thumb)['filename'])[0];
            if (in_array($video_file_name, $video_done)) {
                continue;
            }
            $video = \Video::getInstance()->getOne(['file_name' => $video_file_name]);
            if (!empty($video)) {
                self::importOldThumbFromDisk($video);

                //delete duplicate
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
                if (count($video_done) >= $limit) {
                    $video_done = [];
                }
                $video_done[] = $video_file_name;
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

//        delete_empty_directories(\DirPath::get('thumbs'));
    }
}
