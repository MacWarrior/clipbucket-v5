<?php
/**
 * @throws Exception
 */
function install_global_announcement(): void
{
    execute_sql_file(__DIR__.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'install.sql');
}

install_global_announcement();
