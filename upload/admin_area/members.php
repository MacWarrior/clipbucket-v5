<?php
define('THIS_PAGE', 'members');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $pages, $eh;

userquery::getInstance()->admin_login_check();
userquery::getInstance()->login_check('member_moderation');
$pages->page_redir();
$udetails = userquery::getInstance()->get_user_details(user_id());
$userLevel = $udetails['level'];

if (!empty($_GET['user_not_found'])) {
    e(lang('user_doesnt_exist'));
}
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('users'), 'url' => ''];
if ($_GET['view'] == 'search') {
    $breadcrumb[1] = ['title' => 'Search Members', 'url' => DirPath::getUrl('admin_area') . 'members.php?search=Search'];
} elseif ($_GET['search'] == 'yes' && $_GET['status'] == 'ToActivate') {
    $breadcrumb[1] = ['title' => 'Inactive Only', 'url' => DirPath::getUrl('admin_area') . 'members.php?status=ToActivate&search=Search'];
} elseif ($_GET['search'] == 'yes' && $_GET['status'] == 'Ok') {
    $breadcrumb[1] = ['title' => 'Active Only', 'url' => DirPath::getUrl('admin_area') . 'members.php?status=Ok&search=Search'];
} else {
    $breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('users'))), 'url' => DirPath::getUrl('admin_area') . 'members.php'];
}

$anonymous_id = userquery::getInstance()->get_anonymous_user();
assign('anonymous_id', $anonymous_id);
//Delete User
if (isset($_GET['deleteuser']) && user_id() != $_GET['deleteuser']) {
    if ($anonymous_id == $_GET['deleteuser']) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->delete_user($_GET['deleteuser']);
    }
}

//Deleting Multiple Videos
if (isset($_POST['delete_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anynomous_locked'));
        } else {
            userquery::getInstance()->delete_user($userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been deleted', 'm');
    }
}

//Activate User
if (isset($_GET['activate']) && user_id() != $_GET['deleteuser']) {
    $user = mysql_clean($_GET['activate']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('activate', $user);
    }
}
//Deactivate User
if (isset($_GET['deactivate'])) {
    $user = mysql_clean($_GET['deactivate']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('deactivate', $user);
    }
}

//Using Multiple Action
if (isset($_POST['activate_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } elseif($userid != user_id()) {
            userquery::getInstance()->action('activate', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been activated', 'm');
    }
}

if (isset($_POST['deactivate_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } elseif($userid != user_id()) {
            userquery::getInstance()->action('deactivate', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been deactivated', 'm');
    }
}

if (isset($_GET['resend_verif'])) {
    $revrfy_user = $_GET['resend_verif'];
    if ($anonymous_id == $revrfy_user) {
        e(lang('anonymous_locked'));
    } else {
        $send_mail = resend_verification($revrfy_user);
        if ($send_mail) {
            e('Reverification email has been sent to user <strong>' . $send_mail . '</strong>', 'm');
        } else {
            e('Something went wrong trying to send reverification email');
        }
    }
}

//Make User Featured
if (isset($_GET['featured'])) {
    $user = mysql_clean($_GET['featured']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('featured', $user);
    }
}

//Make User UnFeatured
if (isset($_GET['unfeatured'])) {
    $user = mysql_clean($_GET['unfeatured']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('unfeatured', $user);
    }
}

//Using Multiple Action
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } else {
            userquery::getInstance()->action('featured', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been set as featured', 'm');
    }
}
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } else {
            userquery::getInstance()->action('unfeatured', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been removed from featured list', 'm');
    }
}

//Ban User
if (isset($_GET['ban']) && user_id() != $_GET['ban']) {
    $user = mysql_clean($_GET['ban']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('ban', $user);
    }
}

//UnBan User
if (isset($_GET['unban']) && user_id() != $_GET['unban']) {
    $user = mysql_clean($_GET['unban']);
    if ($anonymous_id == $user) {
        e(lang('anonymous_locked'));
    } else {
        userquery::getInstance()->action('unban', $user);
    }
}

//Using Multiple Action
if (isset($_POST['ban_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } elseif($userid != user_id()) {
            userquery::getInstance()->action('ban', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been banned', 'm');
    }
}

if (isset($_POST['unban_selected']) && is_array($_POST['check_user'])) {
    foreach($_POST['check_user'] AS $userid){
        if ($anonymous_id == $userid) {
            e(lang('anonymous_locked'));
        } elseif($userid != user_id()) {
            userquery::getInstance()->action('unban', $userid);
        }
    }
    if( empty(errorhandler::getInstance()->get_error()) ) {
        $eh->flush();
        e('Selected users have been unbanned', 'm');
    }
}

//Calling Video Manager Functions
call_functions(userquery::getInstance()->user_manager_func);

//Getting Member List
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));

if (isset($_GET['category'])) {
    if ($_GET['category'][0] == 'all') {
        $cat_field = '';
    } else {
        $cat_field = $_GET['category'];
    }
}

if (isset($_GET['search'])) {
    $array = [
        'userid'   => $_GET['userid'],
        'username' => $_GET['username'],
        'category' => $cat_field,
        'featured' => $_GET['featured'],
        'ban'      => $_GET['ban'],
        'status'   => $_GET['status'],
        'email'    => $_GET['email'],
        'gender'   => $_GET['gender'],
        'level'    => $_GET['level']
    ];
}

$result_array = $array;
//Getting Video List
$result_array['limit'] = $get_limit;
if (!$array['order']) {
    $result_array['order'] = ' doj DESC ';
}
$users = get_users($result_array);
if ($userLevel > 1) {
    foreach ($users as $key => $currentUser) {
        if ($currentUser['level'] == 1) {
            unset($users[$key]);
        }
    }
}
Assign('users', $users);
Assign('userLevel', (int)$userLevel);

//Collecting Data for Pagination
$mcount = $array;
$mcount['count_only'] = true;
$total_rows = get_users($mcount);
$total_pages = count_pages($total_rows, config('admin_pages'));
$pages->paginate($total_pages, $page);

//Pagination
$pages->paginate($total_pages, $page);

//Category Array
if (is_array($_GET['category'])) {
    $cats_array = [$_GET['category']];
} else {
    preg_match_all('/#([0-9]+)#/', $_GET['category'], $m);
    $cats_array = [$m[1]];
}
$cat_array = [
    lang('vdo_cat'),
    'type'             => 'checkbox',
    'name'             => 'category[]',
    'id'               => 'category',
    'value'            => [$cats_array],
    'hint_1'           => lang('vdo_cat_msg'),
    'display_function' => 'convert_to_categories',
    'category_type'    => 'user'
];
assign('cat_array', $cat_array);

subtitle(lang('manage_x', strtolower(lang('users'))));
template_files('members.html');
display_it();
