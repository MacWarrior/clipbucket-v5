<?php
define('THIS_PAGE', 'upload');
define('PARENT_PAGE', 'upload');
require 'includes/config.inc.php';
global $pages, $Upload, $eh, $userquery, $Cbucket;
$pages->page_redir();
$userquery->logincheck('allow_video_upload', true);

subtitle('upload');

if( empty($Upload->get_upload_options()) ) {
    e(lang('video_upload_disabled'));
    $Cbucket->show_page = false;
    display_it();
    die();
}

$step = 1;
if (isset($_POST['submit_data'])) {
    $Upload->validate_video_upload_form();
    if (empty($eh->get_error())) {
        $step = 2;
    }
}

assign('step', $step);
assign('extensions', $Cbucket->get_extensions('video'));
subtitle(lang('upload'));

if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addJS(['tag-it'.$min_suffixe.'.js' => 'admin']);
$Cbucket->addJS(['pages/upload/upload'.$min_suffixe.'.js' => 'admin']);
$Cbucket->addCSS(['jquery.tagit'.$min_suffixe.'.css' => 'admin']);
$Cbucket->addCSS(['tagit.ui-zendesk'.$min_suffixe.'.css' => 'admin']);

template_files('upload.html');
display_it();
