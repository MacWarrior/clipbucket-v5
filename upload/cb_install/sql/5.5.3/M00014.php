<?php

namespace V5_5_3;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

require_once \DirPath::get('classes') . 'sLog.php';
require_once \DirPath::get('classes') . 'video_thumbs.class.php';
require_once \DirPath::get('classes') . 'photo_thumbs.class.php';

class M00014 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql = 'UPDATE `{tbl_prefix}video_thumbs` SET `version` = \'5.5.2\' WHERE `version` = \'5.5.3\'';
        self::constrainedQuery($sql, [
            'table' => 'video_thumbs'
        ] , [
            'table'  => 'video_thumb',
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_image` (
            id_video_image INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            videoid BIGINT(20) NOT NULL,
            type ENUM(\'thumbnail\',\'poster\', \'backdrop\') NOT NULL,
            num INT NOT NULL,
            is_auto BOOL DEFAULT TRUE NOT NULL,
            UNIQUE KEY (videoid, type, num, is_auto)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_image` ADD CONSTRAINT `video_image_ibfk_1` FOREIGN KEY (videoid) REFERENCES `{tbl_prefix}video` (videoid);', [
            'table'  => 'video',
            'column' => 'videoid'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_image_ibfk_1'
            ]
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}video_thumb` (
            id_video_thumb INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            id_video_image INT NOT NULL,
            width INT NOT NULL,
            height INT NOT NULL,
            extension VARCHAR(4) NOT NULL,
            version VARCHAR(16) NOT NULL,
            is_original_size BOOL DEFAULT FALSE NOT NULL,
            UNIQUE KEY (id_video_image, width, height)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video_thumb` ADD CONSTRAINT `video_thumb_ibfk_1` FOREIGN KEY (id_video_image) REFERENCES `{tbl_prefix}video_image` (id_video_image);', [
            'table'  => 'video_image',
            'column' => 'id_video_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_thumb_ibfk_1'
            ]
        ]);

        $sql = 'CREATE TABLE IF NOT EXISTS `{tbl_prefix}photo_thumb` (
            id_photo_thumb INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            photo_id BIGINT(255) NOT NULL,
            width INT NOT NULL,
            extension VARCHAR(4) NOT NULL,
            version VARCHAR(16) NOT NULL,
            is_original_size BOOL DEFAULT FALSE NOT NULL,
            UNIQUE KEY (photo_id, width)
        );';
        self::query($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}photo_thumb` ADD CONSTRAINT `photo_thumb_ibfk_1` FOREIGN KEY (photo_id) REFERENCES `{tbl_prefix}photos` (photo_id);', [
            'table'  => 'photos',
            'column' => 'photo_id'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'photo_thumb_ibfk_1'
            ]
        ]);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD COLUMN `default_thumbnail` INT ', [
            'table' => 'video'
        ], [
            'table'  => 'video',
            'column' => 'default_thumbnail'
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD CONSTRAINT `video_default_thumb_ibfk_1` FOREIGN KEY (default_thumbnail) REFERENCES `{tbl_prefix}video_image` (id_video_image) ON DELETE SET NULL;', [
            'table'  => 'video_image',
            'column' => 'id_video_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_default_thumb_ibfk_1'
            ]
        ]);

        $limit = 1;
        $offset = 0;
        do {
            $videos = \Video::getInstance()->getAll([
                'limit'                       => $offset . ' , ' . $limit,
                'disable_generic_constraints' => true
            ]);
            $offset += $limit;
            foreach ($videos as $video) {
                $video_thumb_instance = new \VideoThumbs($video['videoid']);
                $video_thumb_instance->prepareFFmpeg();
                $sql_old_thumbs = 'SELECT *
                , CASE WHEN cast(num as int) = ' . (int)$video['default_thumb'] . ' AND type in (\'custom\',\'auto\')THEN 1 ELSE 0 END AS is_default_thumb'
                . ($video['default_poster'] ? ', CASE WHEN cast(num as int) = ' . (int)$video['default_poster'] . ' AND type = \'poster\' THEN 1 ELSE 0 END AS is_default_poster' : '')
                . ($video['default_backdrop'] ? ', CASE WHEN cast(num as int) = ' . (int)$video['default_backdrop'] . ' AND type = \'backdrop\' THEN 1 ELSE 0 END AS is_default_backdrop' : '')
                .', CASE WHEN type != \'custom\' THEN 1 ELSE 0 END AS is_auto
                FROM ' . tbl('video_thumbs') . ' 
                WHERE videoid = ' . (int)$video['videoid'];
                $old_thumbs = \Clipbucket_db::getInstance()->_select($sql_old_thumbs);
                foreach ($old_thumbs as $old_thumb) {
                    $type = $old_thumb['type'];
                    if ($type == 'custom' || $type == 'auto') {
                        $type = 'thumbnail';
                    }
                    $id_video_image = \VideoThumbs::getOne([
                        'videoid' => $video['videoid'],
                        'type'    => $type,
                        'num'     => (int)$old_thumb['num']
                    ])['id_video_image'] ?? null;
                    if (empty($id_video_image)) {
                        $id_video_image = \Clipbucket_db::getInstance()->insert(tbl('video_image'), [
                            'videoid',
                            'type',
                            'num',
                            'is_auto',
                        ], [
                            $video['videoid'],
                            $type,
                            (int)$old_thumb['num'],
                            (int)$old_thumb['is_auto']
                        ], ignore: true);
                        if (empty($id_video_image)) {
                            \DiscordLog::sendDump('error creating video image for video ' . $video['videoid'] . ' type: ' . $type . ' num: ' . $old_thumb['num'] . ' is_auto: ' . $old_thumb['is_auto'] );
                            error_log('error creating video image for video ' . $video['videoid'] . ' type: ' . $type . ' num: ' . $old_thumb['num'] . ' is_auto: ' . $old_thumb['is_auto'] );
                            break;
                        }
                        $sql_field = false;
                        if ((int)$old_thumb['is_default_thumb']) {
                            $sql_field = 'default_thumbnail';
                        } elseif ((int)$old_thumb['is_default_poster']) {
                            $sql_field = 'default_poster';
                        } elseif ((int)$old_thumb['is_default_backdrop']) {
                            $sql_field = 'default_backdrop';
                        }
                        if (!empty($sql_field)) {
                            $sql = 'UPDATE ' . tbl('video') . ' SET '.$sql_field.' = ' . (int)$id_video_image . ' WHERE videoid = ' . (int)$video['videoid'];
                            \Clipbucket_db::getInstance()->execute($sql);
                        }
                    }
                    if ($old_thumb['resolution'] == 'original') {
                        $dimensions = $video_thumb_instance->getVideoDimension();
                        $sizes['width'] = $dimensions['width'];
                        $sizes['height'] = $dimensions['height'];
                    } else {
                        $sizes = \VideoThumbs::getWidthHeightFromSize($old_thumb['resolution']);
                    }
                    \Clipbucket_db::getInstance()->insert(tbl('video_thumb'), [
                        'id_video_image',
                        'width',
                        'height',
                        'extension',
                        'version',
                        'is_original_size'
                    ], [
                        $id_video_image,
                        $sizes['width'] ?? null,
                        $sizes['height'] ?? null,
                        $old_thumb['extension'],
                        $old_thumb['version'],
                        (int)($old_thumb['resolution'] == 'original')
                    ], ignore: true);
                }
            }

        } while (!empty($videos));

        $sql = 'UPDATE ' . tbl('video') . ' SET default_poster = NULL WHERE default_poster = 0';
        \Clipbucket_db::getInstance()->execute($sql);
        $sql = 'UPDATE ' . tbl('video') . ' SET default_backdrop = NULL WHERE default_backdrop = 0';
        \Clipbucket_db::getInstance()->execute($sql);

        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD CONSTRAINT `video_default_poster_ibfk_1` FOREIGN KEY (default_poster) REFERENCES `{tbl_prefix}video_image` (id_video_image) ON DELETE SET NULL;', [
            'table'  => 'video_image',
            'column' => 'id_video_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_default_poster_ibfk_1'
            ]
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` ADD CONSTRAINT `video_default_backdrop_ibfk_1` FOREIGN KEY (default_backdrop) REFERENCES `{tbl_prefix}video_image` (id_video_image) ON DELETE SET NULL;', [
            'table'  => 'video_image',
            'column' => 'id_video_image'
        ], [
            'constraint' => [
                'type' => 'FOREIGN KEY',
                'name' => 'video_default_backdrop_ibfk_1'
            ]
        ]);

        $sql = 'SELECT plugin_id FROM `{tbl_prefix}plugins` WHERE `plugin_folder` = \'cb_server_thumb\' AND `plugin_active` = \'yes\';';
        $is_server_timthumb_installed = !empty(self::req($sql));
        self::generateConfig('keep_ratio_photo', ($is_server_timthumb_installed ? 'yes' : 'no'));
        \myquery::$website_details = [];
        \ClipBucket::getInstance()->configs = \ClipBucket::getInstance()->get_configs();

        self::generateTranslation('option_keep_ratio_photo', [
            'fr'=>'Forcer les proportions des photos',
            'en'=>'Force thumb ratio'
        ]);

        self::generateTranslation('option_keep_ratio_photo_description', [
            'fr'=>'Toutes les vignettes photos auront le même ratio pour être affiché en grille',
            'en'=>'All photos thumbs will have the same ratio to be displayed as a grid'
        ]);

        $limit = 1;
        $offset = 0;
        do {
            $photos = \Photo::getInstance()->getAll([
                'limit' => $offset . ' , ' . $limit,
            ]);
            $offset += $limit;
            foreach ($photos as $photo) {
                $globs = glob(\DirPath::get('photos') . $photo['file_directory'] . DIRECTORY_SEPARATOR . $photo['filename'] . '*_*.*');
                foreach ($globs as $glob) {
                    unlink($glob);
                }
                \PhotoThumbs::generateThumbs($photo, ignore: true);
            }
        } while (!empty($photos));

        $sql = 'DROP TABLE IF EXISTS `{tbl_prefix}video_thumbs`';
        self::query($sql);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `video_thumbs`', [
            'table'  => 'video',
            'column' => 'video_thumbs',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}video` DROP COLUMN `thumbs_version`', [
            'table'  => 'video',
            'column' => 'thumbs_version',
        ]);
        self::alterTable('ALTER TABLE `{tbl_prefix}photos` DROP COLUMN `photo_details`', [
            'table'  => 'photos',
            'column' => 'photo_details',
        ]);

        self::generateTranslation('custom_thumbnail', [
            'fr'=>'Vignettes personnalisées',
            'en'=>'Custom Thumbnails'
        ]);

        self::generateTranslation('custom_poster', [
            'fr'=>'Affiches personnalisées',
            'en'=>'Custom Posters'
        ]);

        self::generateTranslation('custom_backdrop', [
            'fr'=>'Décors personnalisés',
            'en'=>'Custom Backdrops'
        ]);

        self::generateTranslation('error_uploading_thumb', [
            'fr'=>'Erreur lors du téléversement de la vignette',
            'en'=>'Error uploading thumbnail'
        ]);
        
        self::generateTranslation('photo_delete_successfully', [
            'fr'=>'La photo a été supprimée avec succès',
            'en'=>'Photo deleted successfully'
        ]);
        $sql = 'DELETE FROM `{tbl_prefix}plugins` WHERE `plugin_folder` = \'cb_server_thumb\';';
        self::query($sql);

        self::generateTranslation('option_ratio_photo', [
            'fr'=>'Ratio des vignettes photos',
            'en'=>'Ratio of photos thumbs'
        ]);

        self::generateTranslation('show_original', [
            'fr'=>'Afficher l\'original',
            'en'=>'Show original'
        ]);

        self::generateConfig('ratio_photo', '1.7777');
    }

}
