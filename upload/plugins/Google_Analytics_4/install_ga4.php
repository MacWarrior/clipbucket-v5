<?php
function install_ga4(): void
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'install.sql');
}
install_ga4();
