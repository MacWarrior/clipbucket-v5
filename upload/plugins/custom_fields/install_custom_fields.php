<?php
require_once('../includes/common.php');

function install_custom_fields()
{
    Clipbucket_db::getInstance()->execute(
        'CREATE TABLE IF NOT EXISTS ' . tbl("custom_fields") . " (
        `custom_field_list_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
        `custom_field_title` TEXT NOT NULL ,
        `custom_field_type` TEXT NOT NULL ,
        `custom_field_ptype` TEXT NOT NULL ,
        `custom_field_name` TEXT NOT NULL ,
        `custom_field_id` TEXT NOT NULL ,
        `custom_field_value` TEXT NOT NULL ,
        `custom_field_hint_1` TEXT NOT NULL ,
        `custom_field_db_field` TEXT NOT NULL ,
        `custom_field_required` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'no',
        `custom_field_validate_function` TEXT NOT NULL ,
        `custom_field_invalid_err` TEXT NOT NULL ,
        `custom_field_display_function` TEXT NOT NULL ,
        `custom_field_anchor_before` TEXT NOT NULL ,
        `custom_field_anchor_after` TEXT NOT NULL ,
        `custom_field_hint_2` TEXT NOT NULL ,
        `date_added` DATETIME NOT NULL
        ) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;"
    );
}

install_custom_fields();
