<?php
const THIS_PAGE = 'dashboard';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Dashboard', 'url' => ''];

$mode = $_POST['mode'];
if (!isset($mode)) {
    $mode = $_GET['mode'];
}

switch ($mode) {
    case 'add_todo':
        $response = [];
        $value = $_POST['val'];
        if (!empty($value)) {
            myquery::getInstance()->insert_todo($value);
            $response['todo'] = nl2br($value);
            $response['id'] = Clipbucket_db::getInstance()->insert_id();
            echo json_encode($response);
        }
        die();

    case 'delete_todo':
        $id = mysql_clean($_POST['id']);
        myquery::getInstance()->delete_todo($id);
        die();

    case 'add_note':
        $response = [];
        $value = $_POST['note'];
        myquery::getInstance()->insert_note($value);
        $response['note'] = nl2br($value);
        $response['id'] = Clipbucket_db::getInstance()->insert_id();
        echo json_encode($response);
        die();

    case 'delete_note':
        $id = mysql_clean($_POST['id']);
        myquery::getInstance()->delete_note($id);
        die();

    case 'delete_comment':
        Comments::delete(['comment_id' => $_POST['cid']]);
        $error = errorhandler::getInstance()->get_error();
        $warning = errorhandler::getInstance()->get_warning();
        $message = errorhandler::getInstance()->get_message();

        if ($error) {
            $err = $error[0]['val'];
        } else {
            if ($warning) {
                $err = $warning[0]['val'];
            }
        }
        if ($message) {
            $msg = $message[0]['val'];
        }

        $ajax['msg'] = $msg;
        $ajax['err'] = $err;

        echo json_encode($ajax);
        break;

    case 'spam_comment':
        $rating = Comments::setSpam($_POST['cid']);
        $error = errorhandler::getInstance()->get_error();
        $warning = errorhandler::getInstance()->get_warning();
        $message = errorhandler::getInstance()->get_message();

        if ($error) {
            $err = $error[0]['val'];
        } else {
            if ($warning) {
                $err = $warning[0]['val'];
            }
        }
        if ($message) {
            $msg = $message[0]['val'];
        }

        $ajax['msg'] = $msg;
        $ajax['err'] = $err;

        echo json_encode($ajax);
        break;

    case 'remove_spam':
        Comments::unsetSpam($_POST['cid']);
        $error = errorhandler::getInstance()->get_error();
        $warning = errorhandler::getInstance()->get_warning();
        $message = errorhandler::getInstance()->get_message();

        if ($error) {
            $err = $error[0]['val'];
        } else {
            if ($warning) {
                $err = $warning[0]['val'];
            }
        }
        if ($message) {
            $msg = $message[0]['val'];
        }

        $ajax['msg'] = $msg;
        $ajax['err'] = $err;

        echo json_encode($ajax);
        break;
}

$min_suffixe = System::isInDev() ? '' : '.min';

$params = [];
$params['limit'] = 10;
$params['order'] = 'date_added DESC';
if (config('enable_comments_video') != 'yes' && config('enable_comments_photo') != 'yes' && config('enable_comments_channel') != 'yes' && config('enable_comments_collection') != 'yes') {
    $comments = false;
} else {
    $comments = Comments::getAll($params);
    if( empty($comments) ) {
        $comments = [];
    }

    if( config('enable_visual_editor_comments') == 'yes' ){
        ClipBucket::getInstance()->addAdminJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
        ClipBucket::getInstance()->addAdminCSS(['/toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);
    }
}

$update = Update::getInstance();
$can_sse = System::can_sse() ? 'true' : 'false';
assign('can_sse', $can_sse);
Assign('comments', $comments);
assign('changelog_tab', [Update::getInstance()->getCurrentCoreVersionCode() => Update::getInstance()->getCurrentCoreVersion()]);
Assign('is_update_processing', (Update::IsUpdateProcessing() ? 'true' : 'false'));
if( config('enable_update_checker') == '1' ){
    Assign('update_checker_status', $update->getCoreUpdateStatus());
    Assign('update_checker_content', $update->getUpdateHTML());
}

ClipBucket::getInstance()->addAdminJS(['pages/dashboard/dashboard'.$min_suffixe.'.js' => 'admin']);

$info_php = Update::getInstance()->CheckPHPVersion();
$message_php = '';
if (!empty($info_php)) {
    $message_php = lang('confirmation_upgrade_core_php_version_require', ['<b>' . $info_php['php_version'] . '</b>', '<b>' . $info_php['version'] . ' - ' . ($info_php['revision']?:'1') . '</b>']);
}
assign('message_php', $message_php);
template_files('index.html');
display_it();
