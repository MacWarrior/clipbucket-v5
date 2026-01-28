<?php
const THIS_PAGE = 'regenerate_thumbs';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.3', '14')) {
    e('Sorry, you cannot perform this action until the application has been fully updated by an administrator');
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}
# Generating more thumbs
$data = get_video_details($_POST['videoid']);

sendClientResponseAndContinue(function () use($data) {
    e(lang('thumb_regen_start'), 'warning');
    display_thumb_list_start($data);
});
generatingMoreThumbs($data, true);
die();
