<?php
define('THIS_PAGE','cb_conversion_queue');

global $userquery,$pages,$myquery,$db;

require_once '../includes/admin_config.php';
$userquery->admin_login_check();
$pages->page_redir();

/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => 'Tool Box', 'url' => ''];
$breadcrumb[1] = ['title' => 'Conversion Queue Manager', 'url' => ADMIN_BASEURL.'/cb_conversion_queue.php'];

if($_GET['delete_lock']) {
    if(conv_lock_exists()) {
        for($i = 0 ; $i < config('max_conversion') ; $i++){
            if(file_exists(TEMP_DIR.DIRECTORY_SEPARATOR.'conv_lock'.$i.'.loc')) {
                unlink(TEMP_DIR.DIRECTORY_SEPARATOR.'conv_lock'.$i.'.loc');
            }
        }
        e('Conversion lock has been deleted','m');
    } else {
        e('There is no conversion lock');
    }
}

if(isset($_POST['delete_selected']) && is_array($_POST['check_queue'])) {
    $total = count($_POST['check_queue']);
    for($i=0;$i<=$total;$i++) {
        $myquery->queue_action('delete',$_POST['check_queue'][$i]);
    }
    e('Selected items have been deleted','m');
}

if(isset($_POST['processed']) && is_array($_POST['check_queue'])) {
    $total = count($_POST['check_queue']);
    for($i=0;$i<=$total;$i++) {
        $myquery->queue_action('processed',$_POST['check_queue'][$i]);
    }
    e('Selected items have been set changed to processed','m');
}

if(isset($_POST['pending']) && is_array($_POST['check_queue'])) {
    $total = count($_POST['check_queue']);
    for($i=0;$i<=$total;$i++) {
        $myquery->queue_action('pending',$_POST['check_queue'][$i]);
    }
    e('Selected items have been set changed to processed','m');
}

//Getting List of Conversion Queue
$page = mysql_clean($_GET['page']);
$get_limit = create_query_limit($page,RESULTS);
$queue_list = $myquery->get_conversion_queue(NULL, $get_limit);
assign('queues',$queue_list);
$total_rows  = get_videos($vcount);
$total_pages = count_pages($db->count(tbl('conversion_queue'),'cqueue_id'),RESULTS);
$pages->paginate($total_pages,$page);

subtitle('Conversion Queue Manager');
template_files('cb_conversion_queue.html');
display_it();
