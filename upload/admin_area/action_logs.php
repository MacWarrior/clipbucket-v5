<?php
const THIS_PAGE = 'action_logs';

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

User::getInstance()->hasPermissionOrRedirect('admin_access', true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('action_logs'), 'url' => DirPath::getUrl('admin_area') . 'action_logs.php'];
$limit = 20;

//Getting User List
if (isset($_GET['clean'])) {
    Clipbucket_db::getInstance()->execute('TRUNCATE TABLE ' . tbl('action_log'));
}

if (isset($_GET['type']) && in_array($_GET['type'], CBLogs::$allowed_types, true)) {
    $type = $_GET['type'];
    $params['type'] = $type;
}
assign('type', $type??false);
$page = (int)$_GET['page'];
$params_count = $params;
$params_count['count'] = true;
$total_rows = fetch_action_logs($params_count);
$get_limit = create_query_limit($page, $limit, $total_rows);
$total_pages = count_pages($total_rows, $limit);
if ( $page > $total_pages ) {
    $page = $total_pages;
    $_GET['page'] = $page;
}

$links = [
    'upload_video'                               => ['link' => DirPath::getUrl('root').'admin_area/edit_video.php?video=', 'right' => 'video_moderation'],
    'import_tmdb'                                => ['link' => DirPath::getUrl('root').'admin_area/edit_video.php?video=', 'right' => 'video_moderation'],
    'watch_a_video'                              => ['link' => DirPath::getUrl('root').'admin_area/edit_video.php?video=', 'right' => 'video_moderation'],
    'upload_thumb'                               => ['link' => DirPath::getUrl('root').'admin_area/upload_thumbs.php?type=%s&video=%d', 'right' => 'video_moderation'],
    'upload_photo'                               => ['link' => DirPath::getUrl('root').'admin_area/edit_photo.php?photo=', 'right' => 'photos_moderation'],
    'create_new_playlist'                        => ['link' => DirPath::getUrl('root').'admin_area/manage_playlist.php?mode=edit_playlist&pid=', 'right' => 'member_moderation'],
    'login'                                      => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'signup'                                     => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'profile_update'                             => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'subscribe'                                  => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'add_friend'                                 => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'background_upload'                          => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'avatar_upload'                              => ['link' => DirPath::getUrl('root').'admin_area/view_user.php?uid=', 'right' => 'member_moderation'],
    'add_collection'                             => ['link' => DirPath::getUrl('root').'admin_area/edit_collection.php?collection=', 'right' => 'collection_moderation'],
    'v_comment'                                  => ['link' => DirPath::getUrl('root').'admin_area/comments.php?type=v', 'right' => 'video_moderation'],
    'p_comment'                                  => ['link' => DirPath::getUrl('root').'admin_area/comments.php?type=p', 'right' => 'photos_moderation'],
    'cl_comment'                                 => ['link' => DirPath::getUrl('root').'admin_area/comments.php?type=cl', 'right' => 'collection_moderation'],
    Comments::$libelle_type_channel . '_comment' => ['link' => DirPath::getUrl('root').'admin_area/comments.php?type=channel', 'right' => 'member_moderation']
];
$params['limit'] = $get_limit;
$logs = fetch_action_logs($params);
assign('total_logs', count($logs));
assign('logs', $logs);
assign('links', $links);
subtitle(lang('action_logs'));
pages::getInstance()->paginate($total_pages, $page);
template_files('action_logs.html');
display_it();
