<?php
define('THIS_PAGE', 'user_levels');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
global $pages, $Cbucket;

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = [
    'title' => lang('configurations'),
    'url'   => ''
];
$breadcrumb[1] = [
    'title' => lang('manage_x', strtolower(lang('user_levels'))),
    'url'   => DirPath::getUrl('admin_area') . 'user_levels.php'
];

if (!User::getInstance()->hasPermission('allow_manage_user_level') && userquery::getInstance()->udetails['level'] != 1) {
    $Cbucket->show_page = false;
    e('You are not allowed to manage user levels');
}

$mode = $_GET['mode'];
$user_level_id = mysql_clean($_GET['lid']);
$action = mysql_clean($_GET['action']);

//Deleting Level
if ($action == 'delete') {
   UserLevel::deleteUserLevel($user_level_id);
}

switch ($mode) {
    case 'view':
    default:
        Assign('view', 'view');
        break;

    case 'edit':
        //Updating Level permissions
        if (!empty($_POST)) {
            UserLevel::updateUserLevel($user_level_id, $_POST['level_name'], $_POST['permission_value']);
        }

        //Getting Details of $level
        $levelDetails = userquery::getInstance()->get_level_details($user_level_id);
        if (empty($levelDetails)) {
            Assign('view', 'view');
            break;
        }
        Assign('level_details', $levelDetails);

        //Getting Level Permission
        $level_perms = UserLevel::getAllPermissions(['user_level_id' => $user_level_id]);


        $breadcrumb[] = [
            'title' => 'Editing : ' . display_clean(display_clean($levelDetails['user_level_name'])),
            'url'   => DirPath::getUrl('admin_area') . 'user_levels.php?mode=edit&lid=' . display_clean($user_level_id)
        ];

        Assign('level_perms', $level_perms);
        Assign('view', 'edit');
        break;

    case 'add':
        $level_perms = UserLevel::getAllPermissions(['no_values' => true]);

        if (!empty($_POST)) {
            $level_name = mysql_clean($_POST['level_name']);
            if (empty($level_name)) {
                e(lang('please_enter_level_name'));
            } else {
                UserLevel::addUserLevel($level_name, $_POST['permission_value']);
                redirect_to('user_levels.php?added=true');
            }
        }
        Assign('level_perms', $level_perms);
        Assign('view', 'add');
        break;
}

subtitle('User levels');
template_files('user_levels.html');
display_it();
