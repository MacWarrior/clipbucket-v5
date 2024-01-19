CREATE TABLE IF NOT EXISTS `{tbl_prefix}version`(
    `id`       INT(11)     NOT NULL,
    `version`  VARCHAR(16) NOT NULL,
    `revision` INT(11)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_520_ci;
