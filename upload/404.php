<?php
define('THIS_PAGE', '404');
require 'includes/config.inc.php';

if( !empty($_SERVER['REQUEST_URI']) ){
    $url_new = ['video_public', 'videos_public'];
    foreach($url_new as $url){
        if (strpos($_SERVER['REQUEST_URI'], $url) !== false) {
            $msg = 'Vhosts are outdated, URL not recognized : ' . $_SERVER['REQUEST_URI'];
            error_log($msg);
            DiscordLog::sendDump($msg);

            if( User::getInstance()->hasAdminAccess() && in_dev() ) {
                e($msg);
            }
        }
    }
}

template_files('404.html');
display_it();
