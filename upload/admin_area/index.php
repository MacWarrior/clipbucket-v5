<?php
define('THIS_PAGE', 'dashboard');
global $userquery, $myquery, $db, $cbvid, $eh, $cbphoto, $Cbucket;

require_once '../includes/admin_config.php';
$userquery->admin_login_check();

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
            $myquery->insert_todo($value);
            $response['todo'] = nl2br($value);
            $response['id'] = $db->insert_id();
            echo json_encode($response);
        }
        die();

    case 'update_todo': /* Never used yet */
        $id = $_POST['pk'];
        $value = trim($_POST['value']);
        $myquery->update_todo($value, $id);
        echo json_encode(['msg' => 'success']);
        die();

    case 'update_pharse': /* Never used yet */
        $id = $_POST['pk'];
        $value = trim($_POST['value']);
        $myquery->update_pharse($value, $id);
        echo json_encode(['msg' => 'success']);
        die();

    case 'delete_todo':
        $id = mysql_clean($_POST['id']);
        $myquery->delete_todo($id);
        die();
}

$mode = $_POST['mode'];
switch ($mode) {
    case 'add_note':
        $response = [];
        $value = $_POST['note'];
        $myquery->insert_note($value);
        $response['note'] = nl2br($value);
        $response['id'] = $db->insert_id();
        echo json_encode($response);
        die();

    case 'delete_note':
        $id = mysql_clean($_POST['id']);
        $myquery->delete_note($id);
        die();

    case 'delete_comment':
        Comments::delete(['comment_id' => $_POST['cid']]);
        $error = $eh->get_error();
        $warning = $eh->get_warning();
        $message = $eh->get_message();

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
        $error = $eh->get_error();
        $warning = $eh->get_warning();
        $message = $eh->get_message();

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
        $error = $eh->get_error();
        $warning = $eh->get_warning();
        $message = $eh->get_message();

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
$comments = Comments::getAll($params);

$update = Update::getInstance();
Assign('VERSION', $update->getCurrentCoreVersion());
Assign('STATE', strtoupper($update->getCurrentCoreState()));
Assign('comments', $comments);
Assign('changelog_550', $update->getChangelogHTML('550'));
Assign('changelog_541', $update->getChangelogHTML('541'));
Assign('changelog_540', $update->getChangelogHTML('540'));
Assign('changelog_531', $update->getChangelogHTML('531'));
Assign('changelog_530', $update->getChangelogHTML('530'));
if( config('enable_update_checker') == '1' ){
    Assign('update_checker_status', $update->getCoreUpdateStatus());
    Assign('update_checker_content', $update->getUpdateHTML());
}


if(in_dev()){
    $min_suffixe = '';
} else {
    $min_suffixe = '.min';
}
$Cbucket->addAdminJS(['pages/dashboard/dashboard'.$min_suffixe.'.js' => 'admin']);

template_files('index.html');
display_it();
