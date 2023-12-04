<?php
require_once '../includes/admin_config.php';

global $userquery, $pages, $myquery;

$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Manage Comments', 'url' => ADMIN_BASEURL . '/comments.php'];

if( !empty($_POST['check_comments']) && is_array($_POST['check_comments']) ){
    foreach($_POST['check_comments'] AS $id){
        if( isset($_POST['delete_selected']) ){
            Comments::delete(['comment_id' => $id]);
        } else if( isset($_POST['not_spam']) ) {
            Comments::unsetSpam($id);
        } else if( isset($_POST['mark_spam']) ) {
            Comments::setSpam($id);
        }

    }
}

$comment_cond = [];
$comment_cond['order'] = ' comment_id DESC';

$page = $_GET['page'];
$get_limit = create_query_limit($page, RESULTS);
$comment_cond['limit'] = $get_limit;

$type = $_GET['type'] ?? false;
if( $type ){
    $comment_cond['type'] = $type;
}

$comments = Comments::getAll($comment_cond);
assign('comments', $comments);

$comment_cond['count'] = true;
unset($comment_cond['limit']);
$total_rows =  Comments::getAll($comment_cond);
$total_pages = count_pages($total_rows, RESULTS);
$pages->paginate($total_pages, $page);

subtitle(lang('comments'));
template_files('comments.html');
display_it();
