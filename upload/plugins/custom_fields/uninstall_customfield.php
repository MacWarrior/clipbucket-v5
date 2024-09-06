<?php
//Function used to uninstall Plugin
function un_install_customfield()
{
    Clipbucket_db::getInstance()->execute(
        'DROP TABLE ' . tbl('custom_field')
    );
}

un_install_customfield();
