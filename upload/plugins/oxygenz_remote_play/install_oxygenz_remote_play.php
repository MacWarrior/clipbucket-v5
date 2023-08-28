<?php
/**
 * @throws Exception
 */
function install_oxygenz_remote_play()
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'install.sql');
}

install_oxygenz_remote_play();
