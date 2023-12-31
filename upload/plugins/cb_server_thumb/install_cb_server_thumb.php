<?php
function install_cb_server_thumb()
{
    $cache_dir = DirPath::get('cache') . 'cb_server_thumb';
    if (!is_dir($cache_dir)) {
        if (!mkdir($cache_dir, 0755)) {
            e('Unable to create directory \'' . $cache_dir . '\'');
        } else {
            $gitignore = fopen($cache_dir . DIRECTORY_SEPARATOR . '.gitignore', 'w');
            fwrite($gitignore, '*' . PHP_EOL);
        }
    }
}

install_cb_server_thumb();
