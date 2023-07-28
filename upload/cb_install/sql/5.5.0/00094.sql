DELETE FROM `{tbl_prefix}config` WHERE name IN(
    'collection_home_page',
    'collection_channel_page',
    'collection_user_collections',
    'collection_user_favorites'
);

INSERT IGNORE INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('collection_home_top_collections', '4'),
    ('collection_collection_top_collections', '6'),
    ('collection_photos_top_collections', '6');
