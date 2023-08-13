<?php
/**
 * @throws Exception
 */
function install_cb_link_video()
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'install.sql');
}

install_cb_link_video();
