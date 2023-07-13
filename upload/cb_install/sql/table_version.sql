CREATE TABLE `cb_version`
(
    `id`       INT(11)     NOT NULL,
    `version`  VARCHAR(16) NOT NULL,
    `revision` INT(11)     NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;