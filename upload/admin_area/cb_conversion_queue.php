<?php
define('THIS_PAGE', 'cb_conversion_queue');

global $myquery;

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();
pages::getInstance()->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('tool_box'), 'url' => ''];
$breadcrumb[1] = ['title' => 'Conversion Queue Manager', 'url' => DirPath::getUrl('admin_area') . 'cb_conversion_queue.php'];

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
    $total = count($_POST['check_queue']);
    for ($i = 0; $i <= $total; $i++) {
        $myquery->queue_action('delete', $_POST['check_queue'][$i]);
    }
    e('Selected items have been deleted', 'm');
}

if (isset($_POST['processed']) && is_array($_POST['check_queue'])) {
    $total = count($_POST['check_queue']);
    for ($i = 0; $i <= $total; $i++) {
        $myquery->queue_action('processed', $_POST['check_queue'][$i]);
    }
    e('Selected items have been set changed to processed', 'm');
}

if (isset($_POST['pending']) && is_array($_POST['check_queue'])) {
    $total = count($_POST['check_queue']);
    for ($i = 0; $i <= $total; $i++) {
        $myquery->queue_action('pending', $_POST['check_queue'][$i]);
    }
    e('Selected items have been set changed to processed', 'm');
}

//Getting List of Conversion Queue
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page, config('admin_pages'));
$queue_list = $myquery->get_conversion_queue(null, $get_limit);
assign('queues', $queue_list);
$total_rows = get_videos($vcount);
$total_pages = count_pages(Clipbucket_db::getInstance()->count(tbl('conversion_queue'), 'cqueue_id'), config('admin_pages'));
pages::getInstance()->paginate($total_pages, $page);
assign('admin_url', DirPath::getUrl('admin_area'));
subtitle('Conversion Queue Manager');
template_files('cb_conversion_queue.html');
display_it();
