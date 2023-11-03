UPDATE `{tbl_prefix}video` SET `broadcast` = 'public' WHERE `broadcast` = '';

ALTER TABLE `{tbl_prefix}collections` ADD FULLTEXT KEY `collection_name` (`collection_name`);
ALTER TABLE `{tbl_prefix}users` ADD FULLTEXT KEY `username_fulltext` (`username`);
