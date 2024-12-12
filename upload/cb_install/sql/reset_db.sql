SET FOREIGN_KEY_CHECKS = 0;
SET SESSION group_concat_max_len = 10000;
SET @tables = NULL;
SELECT GROUP_CONCAT('`', table_schema, '`.`', table_name, '`') INTO @tables
FROM information_schema.TABLES
WHERE table_schema = '{dbname}';

DROP PROCEDURE IF EXISTS reset_db;
CREATE PROCEDURE reset_db() BEGIN IF @tables IS NOT NULL THEN SET @tables = CONCAT('DROP TABLE IF EXISTS ', @tables); PREPARE stmt FROM @tables; EXECUTE stmt; DEALLOCATE PREPARE stmt; END IF; END;
CALL reset_db();
SET FOREIGN_KEY_CHECKS = 1;
