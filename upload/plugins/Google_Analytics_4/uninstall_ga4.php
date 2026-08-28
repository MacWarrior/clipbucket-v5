<?php
function uninstall_ga4(): void
{
    execute_sql_file(__DIR__ . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . 'uninstall.sql');
}
uninstall_ga4();
