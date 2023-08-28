<?php
/**
 * @throws Exception
 */
function uninstall_oxygenz_remote_play()
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'uninstall.sql');;
}

uninstall_oxygenz_remote_play();
