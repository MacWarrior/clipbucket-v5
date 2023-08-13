<?php
/**
 * @throws Exception
 */
function uninstall_cb_link_video()
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'uninstall.sql');;
}

uninstall_cb_link_video();
