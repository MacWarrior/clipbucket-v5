ALTER TABLE `{tbl_prefix}plugins`
    MODIFY COLUMN `plugin_version` FLOAT NOT NULL DEFAULT '0';
