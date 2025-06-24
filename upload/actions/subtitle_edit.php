<?php
define('THIS_PAGE', 'subtitle_edit');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('edit_video');

$can_update = true;
$title = $_POST['title'];
if (empty($title)) {
    $can_update = false;
    e(lang('missing_params'));
}
$video = $_POST['videoid'];
$number = $_POST['number'];
$data = get_video_details($video);
$subtitle_list = get_video_subtitles($data);
foreach ($subtitle_list as $subtitle) {
    if ($subtitle['title'] == $title) {
        $can_update = false;
        e(lang('subtitle_already_exists'));
    }
}
if ($can_update) {
    CBvideo::getInstance()->update_subtitle($video, $number, $title);
}
assign('videoid', $data['videoid']);
assign('vstatus', $data['status']);
$subtitle_list_new = get_video_subtitles($data);
display_subtitle_list($subtitle_list_new);
