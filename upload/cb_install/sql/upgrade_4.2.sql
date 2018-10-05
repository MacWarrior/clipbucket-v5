-- enabling Fulltext search with InnoDB as mysql engine
ALTER TABLE `{tbl_prefix}video` ADD FULLTEXT INDEX (`title`,`tags`);