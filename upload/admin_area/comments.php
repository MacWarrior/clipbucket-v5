<?php
require_once '../includes/admin_config.php';

global $userquery, $pages, $myquery;

$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Manage Comments', 'url' => ADMIN_BASEURL . '/comments.php'];

/* Delete comments */
if (isset($_POST['delete_selected']) && is_array($_POST['check_comments'])) {
    foreach ($_POST['check_comments'] as $key => $value) {
        $myquery->delete_comment($value);
    }
}

/* Make spam */
if (isset($_POST['not_spam']) && is_array($_POST['check_comments'])) {
    for ($id = 0; $id <= count($_POST['check_comments']); $id++) {
        $myquery->spam_comment($_POST['check_comments'][$id]);
    }
}
/* Remove Make spam */
if (isset($_POST['mark_spam']) && is_array($_POST['check_comments'])) {
    for ($id = 0; $id <= count($_POST['check_comments']); $id++) {
        $myquery->remove_spam($_POST['check_comments'][$id]);
    }
}

if (empty($_GET['type'])) {
    $type = 'v';
} else {
    $type = $_GET['type'];
}
$comment_cond = [];
$comment_cond['order'] = ' comment_id DESC';

$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, RESULTS);
$comment_cond['limit'] = $get_limit;
assign('type', $type);
switch ($type) {
    case 'v':
    default:
        $comment_cond['type'] = 'v';
        $comment_cond['type_id'] = 'videoid';
        $comment_cond['sectionTable'] = 'video';
        break;

    case 'u':
        $comment_cond['type'] = 'u';
        $comment_cond['type_id'] = 'userid';
        $comment_cond['sectionTable'] = 'users';
        break;

    case 'cl':
        $comment_cond['type'] = 'cl';
        $comment_cond['type_id'] = 'collection_id';
        $comment_cond['sectionTable'] = 'collections';
        break;

    case 'p':
        $comment_cond['type'] = 'p';
        $comment_cond['type_id'] = 'photo_id';
        $comment_cond['sectionTable'] = 'photos';
        break;
}
$comments = getComments($comment_cond);
assign('comments', $comments);

$comment_cond['count_only'] = true;
$total_rows = getComments($comment_cond);
$total_pages = count_pages($total_rows, RESULTS);
$pages->paginate($total_pages, $page);

subtitle(lang('comments'));
template_files('comments.html');
display_it();
