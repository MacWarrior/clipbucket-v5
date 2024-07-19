<?php
define('THIS_PAGE', 'dashboard');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
userquery::getInstance()->admin_login_check();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Dashboard', 'url' => ''];

if (!empty($_GET['finish_upgrade'])) {
    e('Your database has been successfuly updated to version ' . display_clean($_GET['version']), 'm');
}

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

$params = [];
$params['limit'] = 10;
$params['order'] = 'date_added DESC';
if (config('enable_comments_video') != 'yes' && config('enable_comments_photo') != 'yes' && config('enable_comments_channel') != 'yes' && config('enable_comments_collection') != 'yes') {
    $comments = false;
} else {
    $comments = Comments::getAll($params);
    if( empty($comments) ){
        $comments = [];
    }
}

$update = Update::getInstance();
$can_sse = System::can_sse() ? 'true' : 'false';
assign('can_sse', $can_sse);
Assign('VERSION', $update->getCurrentCoreVersion());
Assign('STATE', strtoupper($update->getCurrentCoreState()));
Assign('comments', $comments);
Assign('changelog_551', $update->getChangelogHTML('551'));
Assign('changelog_550', $update->getChangelogHTML('550'));
Assign('changelog_541', $update->getChangelogHTML('541'));
Assign('changelog_540', $update->getChangelogHTML('540'));
Assign('changelog_531', $update->getChangelogHTML('531'));
Assign('changelog_530', $update->getChangelogHTML('530'));
Assign('is_update_processing', (Update::IsUpdateProcessing() ? 'true' : 'false'));
if( config('enable_update_checker') == '1' ){
    Assign('update_checker_status', $update->getCoreUpdateStatus());
    Assign('update_checker_content', $update->getUpdateHTML());
}

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/dashboard/dashboard'.$min_suffixe.'.js' => 'admin']);

template_files('index.html');
display_it();
