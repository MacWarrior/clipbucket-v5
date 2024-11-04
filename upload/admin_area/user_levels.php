<?php
define('THIS_PAGE', 'user_levels');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';
require_once DirPath::get('classes') . 'migration' . DIRECTORY_SEPARATOR . 'migration.class.php';
global $pages, $Cbucket;
userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('admin_access');
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

if (!has_access('allow_manage_user_level') && userquery::getInstance()->udetails['level'] != 1) {
    $Cbucket->show_page = false;
    e('You are not allowed to manage user levels');
}

$mode = $_GET['mode'];
$user_level_id = mysql_clean($_GET['lid']);
$action = mysql_clean($_GET['action']);

//Deleting Level
if ($action == 'delete') {
    userquery::getInstance()->delete_user_level($user_level_id);
}

switch ($mode) {
    case 'view':
    default:
        Assign('view', 'view');
        assign('levels', User::getInstance()->getUserLevels());
        break;

    case 'edit':
        //Updating Level permissions
        if (!empty($_POST)) {
            userquery::getInstance()->update_user_level($user_level_id, $_POST);
        }

        //Getting Details of $level
        $levelDetails = userquery::getInstance()->get_level_details($user_level_id);
        $users = Clipbucket_db::getInstance()->select(tbl('users'), '*', ' level=' . mysql_clean($user_level_id), '1');
        assign('has_users', !empty($users));
        if (empty($levelDetails)) {
            Assign('view', 'view');
            break;
        }
        Assign('level_details', $levelDetails);

        //Getting Level Permission
        $level_perms = userquery::getInstance()->get_level_permissions($user_level_id);

        $plugin_perms = $level_perms['plugins_perms'];
        $plugin_perms = json_decode($plugin_perms, true);

        $breadcrumb[] = [
            'title' => 'Editing : ' . display_clean(display_clean($levelDetails['user_level_name'])),
            'url'   => DirPath::getUrl('admin_area') . 'user_levels.php?mode=edit&lid=' . display_clean($user_level_id)
        ];

        assign('plugin_perms', $plugin_perms);
        Assign('level_perms', $level_perms);
        Assign('view', 'edit');
        break;
    case 'add':
        if (!empty($_POST)) {
            if (userquery::getInstance()->add_user_level($_POST)) {
                redirect_to('user_levels.php?added=true');
            }
        }
        Assign('view', 'add');
        break;
}

subtitle('User levels');
template_files('user_levels.html');
display_it();
