-- Use this SQL script to upgrade from CB commercial to 5.X

UPDATE `{tbl_prefix}video`
	SET video_version = 'COMMERCIAL';
