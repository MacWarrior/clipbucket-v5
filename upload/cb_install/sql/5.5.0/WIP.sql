ALTER TABLE `{tbl_prefix}tools_status` RENAME `{tbl_prefix}tools_histo_status`;
ALTER TABLE `{tbl_prefix}tools_histo_status` RENAME COLUMN `id_tools_status` TO `id_tools_histo_status`;

SET @constraint_name = (SELECT CONSTRAINT_NAME
                        FROM information_schema.key_column_usage
                        WHERE CONSTRAINT_SCHEMA = '{dbname}'
                          AND TABLE_NAME = '{tbl_prefix}tools'
                          AND REFERENCED_TABLE_NAME IS NOT NULL);

SET @sql = 'ALTER TABLE `{tbl_prefix}tools` DROP FOREIGN KEY @constraint_name;';
SET @sql = REPLACE(@sql, '@constraint_name', @constraint_name);

PREPARE alterTable FROM @sql;
EXECUTE alterTable;
ALTER TABLE `{tbl_prefix}tools` DROP COLUMN id_tools_status, DROP COLUMN elements_total, DROP COLUMN elements_done;


CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo`
(
    `id_histo`              INT      NOT NULL AUTO_INCREMENT,
    `id_tool`               INT      NOT NULL,
    `id_tools_histo_status` INT      NOT NULL,
    `date_start`            DATETIME NOT NULL,
    `date_end`              DATETIME NULL,
    `elements_total`        INT      NULL,
    `elements_done`         INT      NULL,
    PRIMARY KEY (`id_histo`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tools_histo`
    ADD CONSTRAINT `id_tools_histo` FOREIGN KEY (`id_tool`) REFERENCES `{tbl_prefix}tools` (`id_tool`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    ADD CONSTRAINT `id_tools_histo_status` FOREIGN KEY (`id_tools_histo_status`) REFERENCES `{tbl_prefix}tools_histo_status` (`id_tools_histo_status`) ON DELETE NO ACTION ON UPDATE NO ACTION;

CREATE TABLE IF NOT EXISTS `{tbl_prefix}tools_histo_log`
(
    `id_log`   INT          NOT NULL AUTO_INCREMENT,
    `id_histo` INT          NOT NULL,
    `datetime` DATETIME     NOT NULL,
    `message`  VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id_log`)
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE utf8mb4_unicode_520_ci;

ALTER TABLE `{tbl_prefix}tools_histo_log`
    ADD CONSTRAINT `id_tools_histo_log` FOREIGN KEY (`id_histo`) REFERENCES `{tbl_prefix}tools_histo` (`id_histo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

UPDATE `{tbl_prefix}tools` SET function_name = REPLACE(function_name, 'AdminTool::', '')