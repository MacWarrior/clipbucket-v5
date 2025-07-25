<?php
const THIS_PAGE = 'comments';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';


User::getInstance()->hasPermissionOrRedirect('admin_access', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('manage_x', strtolower(lang('comments'))), 'url' => DirPath::getUrl('admin_area') . 'comments.php'];

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
$get_limit = create_query_limit($page, config('admin_pages'));
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
$total_pages = count_pages($total_rows, config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);

$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/comments/comments'.$min_suffixe.'.js' => 'admin']);

if( config('enable_visual_editor_comments') == 'yes' ){
    ClipBucket::getInstance()->addAdminJS(['toastui/toastui-editor-all' . $min_suffixe . '.js' => 'libs']);
    ClipBucket::getInstance()->addAdminCSS(['/toastui/toastui-editor' . $min_suffixe . '.css' => 'libs']);
}

subtitle(lang('comments'));
template_files('comments.html');
display_it();
