<?php
/**
 * @throws \Exception
 */
function install_editors_pick()
{
    execute_sql_file(__DIR__.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'install.sql');
}

install_editors_pick();
