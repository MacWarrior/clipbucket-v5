<?php
if( !defined('THIS_PAGE') ){
    define('THIS_PAGE', 'popin_upload_subtitle_core');
    require 'includes/config.inc.php';
    redirect_to(cblink(['name' => 'error_403']));
}

$response=[];
if (empty($_POST['videoid'])) {
    e(lang('missing_params'));
    $response['success'] = false;
    $response['msg'] = getTemplateMsg();
    echo json_encode($response);
    die();
}

$data = Video::getInstance()->getOne(['videoid' => $_POST['videoid']]);
if ($data['userid'] != User::getInstance()->getCurrentUserID() && !User::getInstance()->hasAdminAccess()) {
    e(lang('insufficient_privileges'));
    echo json_encode(['success' => false, 'msg'=>getTemplateMsg()]);
    die();
}

$response['success'] = true;
assign('videoid', mysql_clean($_POST['videoid']));
$response += templateWithMsgJson('blocks/popin_upload_subtitle.html',false);
echo json_encode($response);
