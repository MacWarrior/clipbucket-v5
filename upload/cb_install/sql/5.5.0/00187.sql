ALTER TABLE `{tbl_prefix}plugins`
    DROP IF EXISTS `plugin_license_type`,
    DROP IF EXISTS `plugin_license_key`,
    DROP IF EXISTS `plugin_license_code`;
