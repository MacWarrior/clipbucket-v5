ALTER TABLE `{tbl_prefix}user_profile`
    MODIFY COLUMN `avatar` VARCHAR(225) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no_avatar.png';
