<?php
/**
 * @throws Exception
 */
function uninstall_social_networks()
{
    execute_sql_file(__DIR__.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'uninstall.sql');;
}

uninstall_social_networks();
