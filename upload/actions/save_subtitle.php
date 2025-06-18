<?php
define('THIS_PAGE', 'save_subtitle');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionAjax('edit_video');
$response = [];
if (empty($_POST['videoid']) || empty($_FILES['subtitles'])) {
    e(lang('missing_params'));
    $response['success'] = false;
    $response['msg'] = getTemplateMsg();
    echo json_encode($response);
    die;
}

$video = Video::getInstance()->getOne(['videoid' => mysql_clean($_POST['videoid'])]);
$subtitle_dir = DirPath::get('subtitles') . $video['file_directory'] . DIRECTORY_SEPARATOR;
if (!is_dir($subtitle_dir)) {
    mkdir($subtitle_dir, 0755, true);
}
$num = (int)get_video_subtitle_last_num($video['videoid']);
$display_count = str_pad((string)($num + 1), 2, '0', STR_PAD_LEFT);
$temp_file_path = $subtitle_dir . $video['file_name'] . '-' . $display_count . '.srt';

if (pathinfo($_FILES['subtitles']['name'])['extension']!= 'srt') {
    e(lang('invalid_subtitle_extension'));
    $success = false;
} elseif (!FFMpeg::isValidWebVTTWithFFmpeg($_FILES['subtitles']['tmp_name'])) {
    e(lang('invalid_subtitle_file'));
    $success = false;
} elseif ($_FILES['subtitles']['size'] >= (1024 * 1024 * config('maximum_allowed_subtitle_size')) ) {
    e(lang('file_size_exceeded', config('maximum_allowed_subtitle_size') . lang('mb')));
    $success = false;
} else {
    rename($_FILES['subtitles']['tmp_name'], $temp_file_path);
    Clipbucket_db::getInstance()->insert(tbl('video_subtitle'), ['videoid', 'number', 'title'], [$video['videoid'], $display_count, mysql_clean($_POST['title'])], null, true);
    e(lang('subtitle_uploaded_successfully'), 'm');
    $success = true;
}

$response['success'] = $success;
$response['msg'] = getTemplateMsg();
echo json_encode($response);
