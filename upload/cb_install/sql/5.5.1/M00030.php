<?php

namespace V5_5_1;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00030 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $tables = ['action_log','admin_notes','admin_todo','ads_data','ads_placements','categories','categories_type','collections','collections_categories','collection_items','collection_tags','comments','config','contacts','conversion_queue','counters','countries','email_templates','favorites','flags','languages','languages_keys','languages_translations','mass_emails','messages','pages','photos','photos_categories','photo_tags','playlists','playlists_categories','playlist_items','playlist_tags','plugins','plugin_config','sessions','stats','subscriptions','tags','tags_type','template','tmdb_search','tmdb_search_result','tools','tools_histo','tools_histo_log','tools_histo_status','users','users_categories','user_levels','user_levels_permissions','user_permissions','user_permission_types','user_profile','user_tags','version','video','videos_categories','video_favourites','video_files','video_resolution','video_subtitle','video_tags','video_thumbs','video_views'];
        foreach($tables as $table){
            $sql = 'ALTER TABLE `{tbl_prefix}' . $table . '` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;';
            self::query($sql);
        }

        $sql = 'CREATE TEMPORARY TABLE IF NOT EXISTS tmb_config_to_delete
            WITH all_duplicates AS (
                SELECT * FROM `{tbl_prefix}config` WHERE `name` IN (SELECT `name` FROM `{tbl_prefix}config` GROUP BY `name` HAVING COUNT(*) > 1 )
            )
            , keep_one_of_each_duplicate AS (
                SELECT MIN(`configid`) AS configid, `name` FROM all_duplicates GROUP BY `name`
            )
            , all_duplicated_except_one_of_each AS (
                SELECT `configid` FROM all_duplicates WHERE `configid` NOT IN (SELECT `configid` FROM keep_one_of_each_duplicate )
            )
            SELECT `configid` FROM all_duplicated_except_one_of_each;';
        self::query($sql);

        $sql = 'DELETE FROM `{tbl_prefix}config` WHERE `configid` IN(SELECT `configid` FROM tmb_config_to_delete);';
        self::query($sql);
    }
}