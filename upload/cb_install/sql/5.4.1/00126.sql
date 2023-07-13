ALTER TABLE `{tbl_prefix}video`
    MODIFY COLUMN `datecreated` DATE NOT NULL DEFAULT '1000-01-01';
UPDATE `{tbl_prefix}video` SET datecreated = '1000-01-01' WHERE datecreated = '0000-00-00';
