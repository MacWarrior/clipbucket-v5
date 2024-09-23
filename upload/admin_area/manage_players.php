<?php
define('THIS_PAGE', 'manage_players');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $Upload, $myquery, $cbplayer;
userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();
userquery::getInstance()->login_check('admin_access');

if( count($cbplayer->getPlayers()) <= 1 && !in_dev() && $_GET['mode'] != 'show_settings' ){
    redirect_to(BASEURL . DirPath::getUrl('admin_area'));
}

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title'=> lang('configurations'), 'url'=>''];
if ($_GET['mode'] == 'show_settings') {
    $breadcrumb[1] = ['title' => lang('player_settings'), 'url' => DirPath::getUrl('admin_area') . 'manage_players.php?mode=show_settings'];
} else {
    $breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('players'))), 'url' => DirPath::getUrl('admin_area') . 'manage_players.php'];
}

//Set Mode
assign('mode', $_GET['mode']);

if (isset($_POST['update'])) {
    $rows = [
        'autoplay_video',
        'embed_player_height',
        'embed_player_width',
        'autoplay_embed',
        'chromecast',
        'control_bar_logo',
        'contextual_menu_disabled',
        'control_bar_logo_url',
        'player_logo_url',
        'player_thumbnails',
        'player_default_resolution',
        'player_default_resolution_hls',
        'player_subtitles'
    ];

    //Checking for logo
    if (isset($_FILES['logo_file']['name'])) {
        $logo_file = $Upload->upload_website_logo($_FILES['logo_file']);
        if ($logo_file) {
            $myquery->Set_Website_Details('player_logo_file', $logo_file);
        }
    }

    foreach ($rows as $field) {
        if ($field == 'control_bar_logo_url') {
            if (is_null($_FILES[$field]) || empty($_FILES[$field]['tmp_name'])) {
                continue;
            }
            if (file_exists(DirPath::get('logos') . 'player-logo.png')) {
                unlink(DirPath::get('logos') . 'player-logo.png');
            }
            $_POST['control_bar_logo_url'] = DirPath::getUrl('logos') . 'player-logo.png';
            move_uploaded_file($_FILES[$field]['tmp_name'], DirPath::get('logos') . 'player-logo.png');
        }

        $value = mysql_clean($_POST[$field]);
        $myquery->Set_Website_Details($field, $value);
    }
    e(lang('player_settings_updated'), 'm');
}

if (isset($_POST['reset_control_bar_logo_url'])) {
    if (file_exists(DirPath::get('logos') . 'player-logo.png')) {
        unlink(DirPath::get('logos') . 'player-logo.png');
    }
    $myquery->Set_Website_Details('control_bar_logo_url', '/images/icons/player-logo.png');
    e(lang('player_logo_reset'), 'm');
}

if ($_GET['set']) {
    $cbplayer->set_player($_GET);
}

$row = $myquery->Get_Website_Details();
Assign('row', $row);

subtitle('Manage Players');
template_files('manage_players.html');
display_it();
