ALTER TABLE `{tbl_prefix}collections`
    ADD `collection_id_parent` BIGINT(25) NULL DEFAULT NULL AFTER `collection_id`,
    ADD INDEX(`collection_id_parent`);
ALTER TABLE `{tbl_prefix}collections`
    ADD FOREIGN KEY (`collection_id_parent`) REFERENCES `{tbl_prefix}collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
INSERT INTO `{tbl_prefix}config`(`name`, `value`) VALUES
    ('enable_sub_collection', '1');
