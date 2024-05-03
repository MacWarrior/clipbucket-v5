<?php
namespace V5_5_0;
require_once \DirPath::get('classes') . DIRECTORY_SEPARATOR . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';

class M00009 extends \Migration
{
    /**
     * @throws \Exception
     */
    public function start()
    {
        $sql='DELETE FROM `{tbl_prefix}config` WHERE `name` IN (
            \'high_resolution\'
            , \'normal_resolution\'
            , \'videos_list_per_tab\'
            , \'channels_list_per_tab\'
            , \'code_dev\'
            , \'player_div_id\'
            , \'channel_player_width\'
            , \'channel_player_height\'
            , \'use_crons\'
            , \'grp_max_title\'
            , \'grp_max_desc\'
            , \'grp_thumb_width\'
            , \'grp_thumb_height\'
            , \'grp_categories\'
            , \'max_bg_height\'
            , \'max_profile_pic_height\'
        );';
        self::query($sql);
    }
}