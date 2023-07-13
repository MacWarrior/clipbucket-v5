DELETE FROM `{tbl_prefix}config` WHERE `name` IN (
    'default_time_zone'
    ,'user_max_chr'
    ,'captcha_type'
    ,'user_rate_opt1'
    ,'max_time_wait'
    ,'index_featured'
    ,'index_recent'
    ,'videos_items_columns'
);
