<?php
function delete_directory($dirname): bool
{
    $dir_handle = false;
    if (is_dir($dirname)) {
        $dir_handle = opendir($dirname);
    }
    if (!$dir_handle) {
        return false;
    }
    while ($file = readdir($dir_handle)) {
        if ($file != '.' && $file != '..') {
            if (!is_dir($dirname . DIRECTORY_SEPARATOR . $file)) {
                unlink($dirname . DIRECTORY_SEPARATOR . $file);
            } else {
                delete_directory($dirname . DIRECTORY_SEPARATOR . $file);
            }
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

function uninstall_cb_server_thumb()
{
    $cache_dir = DirPath::get('cache') . 'cb_server_thumb';
    if (!delete_directory($cache_dir)) {
        e('Unable to remove directory \'' . $cache_dir . '\'');
    }
}

uninstall_cb_server_thumb();
