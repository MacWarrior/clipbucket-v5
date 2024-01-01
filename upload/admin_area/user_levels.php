<?php
define('THIS_PAGE', 'user_levels');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $userquery, $pages, $Cbucket;
$userquery->admin_login_check();
$userquery->login_check('admin_access');
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('users'), 'url' => ''];
$breadcrumb[1] = ['title' => 'User Levels', 'url' => DirPath::getUrl('admin_area') . 'user_levels.php'];

if (!has_access('allow_manage_user_level') && $userquery->udetails['level'] != 1) {
    $Cbucket->show_page = false;
    e('You are not allowed to manage user levels');
}

$mode = $_GET['mode'];
$lid = mysql_clean($_GET['lid']);
$action = mysql_clean($_GET['action']);

//Deleting Level
if ($action == 'delete') {
    $userquery->delete_user_level($lid);
}

switch ($mode) {
    case 'view':
    default:
        Assign('view', 'view');
        break;

    case 'edit':
        //Updating Level permissions
        if (isset($_POST['update_level_perms'])) {
            $perm_array = $_POST;
            $userquery->update_user_level($lid, $perm_array);
        }

        //Getting Details of $level
        $levelDetails = $userquery->get_level_details($lid);
        Assign('level_details', $levelDetails);

        //Getting Level Permission
        $level_perms = $userquery->get_level_permissions($lid);

        $plugin_perms = $level_perms['plugins_perms'];
        $plugin_perms = json_decode($plugin_perms, true);

        assign('plugin_perms', $plugin_perms);
        Assign('level_perms', $level_perms);
        Assign('view', 'edit');
        break;

    case 'add':
        if (isset($_POST['add_new_level'])) {
            $array = $_POST;
            if ($userquery->add_user_level($array)) {
                redirect_to('user_levels.php?added=true');
            }
        }
        Assign('view', 'add');
        break;
}

subtitle('User levels');
template_files('user_levels.html');
display_it();
