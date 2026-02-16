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
        if (!is_dir($new_path)) {
            mkdir($new_path, 0777, true);
        }
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
            $offset += $limit;
            foreach ($videos_images as $videos_image) {
                $path = $videos_image['file_directory'] . DIRECTORY_SEPARATOR . $videos_image['file_name'];
                if (!is_dir($new_path . DIRECTORY_SEPARATOR . $path)) {
                    mkdir($new_path . DIRECTORY_SEPARATOR . $path, 0777, true);
                }
                $resolution = $videos_image['is_original_size'] ? 'original' : '';
                rename(\DirPath::get('thumbs') . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], $videos_image['version'])
                    , $new_path . DIRECTORY_SEPARATOR . \VideoThumbs::getThumbPath($videos_image['type'], $videos_image['file_directory'], $videos_image['file_name'], $videos_image['is_auto'], $videos_image['num'], $resolution, $videos_image['width'], $videos_image['height'], $videos_image['extension'], \Update::getInstance()->getCurrentCoreVersion())
                );
                self::query('UPDATE ' . tbl(\VideoThumbs::getTableNameThumb()) . ' SET version = \'' . \Update::getInstance()->getCurrentCoreVersion() . '\' WHERE id_video_thumb = ' . $videos_image['id_video_thumb']);
            }

        } while (!empty($videos_images));

        delete_empty_directories(\DirPath::get('thumbs'));

        self::insertTool('regenerate_all_video_thumbs', 'AdminTool::regenerateAllVideoThumbs');

        self::generateTranslation('regenerate_all_video_thumbs_label', [
            'fr'=>'Régénère les miniatures des vidéos',
            'en'=>'Regenerate videos thumbs'
        ]);

        self::generateTranslation('regenerate_all_video_thumbs_description', [
            'fr'=>'Régénère toutes les miniatures automatiques de toutes les vidéos',
            'en'=>'Regenerate all video thumbs auto'
        ]);
    }
}
