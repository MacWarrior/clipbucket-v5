-- 2.8
-- Adding new user level permission
-- Author Awais

ALTER TABLE  `{tbl_prefix}user_levels_permissions` ADD  `allow_create_collection` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'yes' AFTER  `allow_manage_user_level`;
ALTER TABLE  `{tbl_prefix}user_levels_permissions` ADD  `allow_create_playlist` ENUM(  'yes',  'no' ) NOT NULL DEFAULT  'yes' AFTER  `allow_create_collection`;
INSERT INTO `{tbl_prefix}user_permissions` (
`permission_id` ,
`permission_type` ,
`permission_name` ,
`permission_code` ,
`permission_desc` ,
`permission_default`
)VALUES(
NULL , '2', 'Allow create collection', 'allow_create_collection', 'Allow users to create collection', 'yes'), (
NULL , '2', 'Allow create playlist', 'allow_create_playlist', 'Allow users to create playlist', 'yes');
INSERT INTO `{tbl_prefix}config` (`configid`, `name`, `value`) VALUES (NULL, 'video_round_views', 'yes');