UPDATE `{tbl_prefix}config`
SET value = CASE WHEN value = '1' THEN 'yes' ELSE 'no' END
WHERE name LIKE 'enable_sub_collection';
