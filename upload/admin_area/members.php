<?php
define('THIS_PAGE', 'members');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

global $userquery, $pages, $eh;

$userquery->admin_login_check();
$userquery->login_check('member_moderation');
$pages->page_redir();
$udetails = $userquery->get_user_details(user_id());
$userLevel = $udetails['level'];

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
    $breadcrumb[1] = ['title' => lang('grp_manage_members_title'), 'url' => DirPath::getUrl('admin_area') . 'members.php'];
}

//Delete User
if (isset($_GET['deleteuser'])) {
    $deleteuser = mysql_clean($_GET['deleteuser']);
    $userquery->delete_user($deleteuser);
}

//Deleting Multiple Videos
if (isset($_POST['delete_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->delete_user($_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been deleted', 'm');
}

//Activate User
if (isset($_GET['activate'])) {
    $user = mysql_clean($_GET['activate']);
    $userquery->action('activate', $user);
}
//Deactivate User
if (isset($_GET['deactivate'])) {
    $user = mysql_clean($_GET['deactivate']);
    $userquery->action('deactivate', $user);
}

//Using Multiple Action
if (isset($_POST['activate_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('activate', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been activated', 'm');
}

if (isset($_POST['deactivate_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('deactivate', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been deactivated', 'm');
}

if (isset($_GET['resend_verif'])) {
    $revrfy_user = $_GET['resend_verif'];
    $send_mail = resend_verification($revrfy_user);
    if ($send_mail) {
        e('Reverification email has been sent to user <strong>' . $send_mail . '</strong>', 'm');
    } else {
        e('Something went wrong trying to send reverification email');
    }
}

//Make User Featured
if (isset($_GET['featured'])) {
    $user = mysql_clean($_GET['featured']);
    $userquery->action('featured', $user);
}

//Make User UnFeatured
if (isset($_GET['unfeatured'])) {
    $user = mysql_clean($_GET['unfeatured']);
    $userquery->action('unfeatured', $user);
}

//Using Multiple Action
if (isset($_POST['make_featured_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('featured', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been set as featured', 'm');
}
if (isset($_POST['make_unfeatured_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('unfeatured', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been removed from featured list', 'm');
}

//Ban User
if (isset($_GET['ban'])) {
    $user = mysql_clean($_GET['ban']);
    $userquery->action('ban', $user);
}

//UnBan User
if (isset($_GET['unban'])) {
    $user = mysql_clean($_GET['unban']);
    $userquery->action('unban', $user);
}

//Using Multiple Action
if (isset($_POST['ban_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('ban', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been banned', 'm');
}

if (isset($_POST['unban_selected']) && is_array($_POST['check_user'])) {
    for ($id = 0; $id <= count($_POST['check_user']); $id++) {
        $userquery->action('unban', $_POST['check_user'][$id]);
    }
    $eh->flush();
    e('Selected users have been unbanned', 'm');
}

//Calling Video Manager Functions
call_functions($userquery->user_manager_func);

//Getting Member List
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, RESULTS);

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
$total_pages = count_pages($total_rows, RESULTS);
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
    'value'            => ['category', $cats_array],
    'hint_1'           => lang('vdo_cat_msg'),
    'display_function' => 'convert_to_categories',
    'category_type'    => 'user'
];
assign('cat_array', $cat_array);

subtitle(lang('grp_manage_members_title'));
template_files('members.html');
display_it();
