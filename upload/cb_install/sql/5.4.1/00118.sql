ALTER TABLE `{tbl_prefix}user_profile`
    MODIFY COLUMN `profile_video` int(255) NOT NULL DEFAULT 0,
    MODIFY COLUMN `profile_item` varchar(25) NOT NULL DEFAULT '',
    MODIFY COLUMN `rating` tinyint(2) NOT NULL DEFAULT 0,
    MODIFY COLUMN `rated_by` int(150) NOT NULL DEFAULT 0;
