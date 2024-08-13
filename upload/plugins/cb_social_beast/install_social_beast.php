<?php
/**
 * @throws Exception
 */
function install_social_beast()
{
    execute_sql_file(__DIR__.DIRECTORY_SEPARATOR.'sql'.DIRECTORY_SEPARATOR.'install.sql');
}

install_social_beast();
