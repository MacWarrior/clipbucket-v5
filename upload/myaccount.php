<?php
define('THIS_PAGE', 'myaccount');
define('PARENT_PAGE', 'home');

require 'includes/config.inc.php';
User::getInstance()->isUserConnectedOrRedirect();

global $cbvid, $cbphoto, $cbvideo;

assign('user', userquery::getInstance()->get_user_details(user_id()));
$videos = userquery::getInstance()->get_user_vids(user_id(), false, false, true);
assign('videos', $videos);
$ids_to_check_progress = [];
if( Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '279') ) {
    foreach ($videos as $video) {
        if (in_array($video['status'], ['Processing', 'Waiting'])) {
            $ids_to_check_progress[] = $video['videoid'];
        }
    }
}
Assign('ids_to_check_progress', json_encode($ids_to_check_progress));

if (isset($_GET['delete_video'])) {
    $video = mysql_clean($_GET['delete_video']);
    $cbvideo->delete_video($video);
}
$storage_use = null;
if (config('enable_storage_history_fo') == 'yes') {
    $storage_use = System::get_readable_filesize(User::getInstance()->getLastStorageUseByUser(user_id()), 2);
}
assign('storage_use', $storage_use);
$favorites = User::getInstance()->getFavoritesVideos(user_id());
assign('favorites', $favorites);
$current_membership = null;
if (config('enable_membership') == 'yes') {
    $current_membership = Membership::getInstance()->getAllHistoMembershipForUser([
        'userid'=>user_id(),
        'first_only'=>true
    ]);
}
assign('current_membership', $current_membership);

subtitle(lang('my_account'));
template_files('myaccount.html');
display_it();
