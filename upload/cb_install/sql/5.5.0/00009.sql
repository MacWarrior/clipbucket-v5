DELETE FROM `{tbl_prefix}config`
WHERE NAME IN (
    'high_resolution'
    , 'normal_resolution'
    , 'videos_list_per_tab'
    , 'channels_list_per_tab'
    , 'code_dev'
    , 'player_div_id'
    , 'channel_player_width'
    , 'channel_player_height'
    , 'use_crons'
    , 'grp_max_title'
    , 'grp_max_desc'
    , 'grp_thumb_width'
    , 'grp_thumb_height'
    , 'grp_categories'
    , 'max_bg_height'
    , 'max_profile_pic_height'
    );
