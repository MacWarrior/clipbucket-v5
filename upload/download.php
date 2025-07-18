<?php
const THIS_PAGE = 'download';
const PARENT_PAGE = 'videos';
require 'includes/config.inc.php';

User::getInstance()->hasPermissionOrRedirect('download_video');
pages::getInstance()->page_redir();

//Getting Video Key
$vkey = @$_GET['v'];
$vdo = CBvideo::getInstance()->get_video($vkey);

if ($vdo && video_playable($vkey)) {
    //Calling Functions When Video Is going to download
    call_download_video_function($vdo);

    $file = get_video_file($vdo, false);

    if ($file) {
        $vdo['download_file'] = $file;
    } else {
        ClipBucket::getInstance()->show_page = false;
        e(lang("unable_find_download_file"));
    }
    assign('vdo', $vdo);
    subtitle("Download " . $vdo['title']);
}

//Displaying The Template
template_files('download.html');
display_it();
