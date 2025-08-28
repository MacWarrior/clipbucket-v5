<?php
const THIS_PAGE = 'cb_conversion_queue';
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

$permission = 'advanced_settings';
if (!Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '275')) {
    $permission = 'web_config_access';
}
User::getInstance()->hasPermissionOrRedirect($permission, true);
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url'   => ''];
$breadcrumb[1] = ['title' => 'Conversion Queue Manager', 'url'   => DirPath::getUrl('admin_area') . 'cb_conversion_queue.php'];

e(lang('conversion_queue_warning'), 'w');

if ($_GET['delete_lock']) {
    if (conv_lock_exists()) {
        for ($i = 0; $i < config('max_conversion'); $i++) {
            if (file_exists(DirPath::get('temp') . 'conv_lock' . $i . '.loc')) {
                unlink(DirPath::get('temp') . 'conv_lock' . $i . '.loc');
            }
        }
        e('Conversion lock has been deleted', 'm');
    } else {
        e('There is no conversion lock');
    }
}

if (isset($_POST['delete_selected']) && is_array($_POST['check_queue'])) {
    if (!empty($_POST['check_queue'])) {
        foreach ($_POST['check_queue'] as $id) {
            myquery::getInstance()->queue_action('delete', $id);
        }
    }
    e('Selected items have been deleted', 'm');
}

if (isset($_POST['resume']) && is_array($_POST['check_queue'])) {
    if (!empty($_POST['check_queue'])) {
        foreach ($_POST['check_queue'] as $id) {
            myquery::getInstance()->queue_action('resume', $id);
        }
    }
    e(lang('selected_conversion_resumed'), 'm');
}

//Getting List of Conversion Queue
$page = (int)$_GET['page'];
$get_limit = create_query_limit($page, config('admin_pages'));
$queue_list = myquery::getInstance()->get_conversion_queue(limit: $get_limit);
assign('queues', $queue_list);

if ($page == 1 && count($queue_list) < config('admin_pages')) {
    $total_pages = 1;
} else {
    $total_pages = count_pages(Clipbucket_db::getInstance()->count(tbl('conversion_queue'), 'cqueue_id'), config('admin_pages'));
}
$min_suffixe = System::isInDev() ? '' : '.min';
ClipBucket::getInstance()->addAdminJS(['pages/cb_conversion_queue/cb_conversion_queue'.$min_suffixe.'.js' => 'admin']);

pages::getInstance()->paginate($total_pages, $page);
assign('admin_url', DirPath::getUrl('admin_area'));
subtitle('Conversion Queue Manager');
template_files('cb_conversion_queue.html');
display_it();
