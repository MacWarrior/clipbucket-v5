CREATE TABLE IF NOT EXISTS `{tbl_prefix}plugin_ga4` (
    `enabled` enum('yes','no') NOT NULL DEFAULT 'no',
    `measurement_id` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `{tbl_prefix}plugin_ga4` (`enabled`, `measurement_id`)
SELECT 'no', ''
WHERE NOT EXISTS (SELECT 1 FROM `{tbl_prefix}plugin_ga4` LIMIT 1);
