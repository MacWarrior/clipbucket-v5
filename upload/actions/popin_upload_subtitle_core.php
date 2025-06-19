<?php

$response=[];
if (empty($_POST['videoid'])) {
    e(lang('missing_params'));
    $response['success'] = false;
    $response['msg'] = getTemplateMsg();
    echo json_encode($response);
    die;
}

$response['success'] = true;
assign('videoid', mysql_clean($_POST['videoid']));
$response += templateWithMsgJson('blocks/popin_upload_subtitle.html',false);
echo json_encode($response);
