<?php
/*
    Plugin Name: ClipBucket Editor's Pick Plugin
    Description: This plugin is used to display Editor's Pick Player On Home Page and also let you pick videos for editor's pick
    Author: Arslan Hassan & MacWarrior
    Website: https://github.com/MacWarrior/clipbucket-v5/
    Version: 2.0.6
    ClipBucket Version: 5.5.1
*/

/**
 * @throws Exception
 */
function editors_pick()
{
    if ($_GET['add_editor_pick']) {
        $vid = mysql_clean($_GET['add_editor_pick']);
        add_to_editor_pick($vid);
    }

    if ($_GET['remove_editor_pick']) {
        $vid = mysql_clean($_GET['remove_editor_pick']);
        remove_vid_editors_pick($vid);
    }
}

/**
 * @throws Exception
 */
function add_to_editor_pick($vid)
{
    global $cbvid;
    if ($cbvid->video_exists($vid)) {
        if (!is_video_in_editors_pick($vid)) {
            $sort = get_highest_sort_number() + 1;
            Clipbucket_db::getInstance()->insert(tbl('editors_picks'), ['videoid', 'sort', 'date_added'], [$vid, $sort, now()]);
            Clipbucket_db::getInstance()->update(tbl('video'), ['in_editor_pick'], ['yes'], ' videoid = \'' . $vid . '\'');
            e(lang('plugin_editors_picks_added'), 'm');
        } else {
            e(lang('plugin_editors_picks_add_error'), 'e');
        }
    } else {
        e(lang('class_vdo_exist_err'));
    }
}

/**
 * @throws Exception
 */
function remove_vid_editors_pick($vid)
{
    if (is_array($vid)) {
        $vid = $vid['videoid'];
    }
    if (is_video_in_editors_pick($vid)) {
        Clipbucket_db::getInstance()->delete(tbl('editors_picks'), ['videoid'], [$vid]);
        Clipbucket_db::getInstance()->update(tbl('video'), ['in_editor_pick'], ['no'], ' videoid = \'' . $vid . '\'');
        e(lang('plugin_editors_picks_removed'), 'm');
    }
}

/**
 * @throws Exception
 */
function is_video_in_editors_pick($vid): bool
{
    $count = Clipbucket_db::getInstance()->count(tbl('editors_picks'), 'videoid', ' videoid = \'' . $vid . '\'');
    if ($count > 0) {
        return true;
    }
    return false;
}

/**
 * @throws Exception
 */
function get_highest_sort_number()
{
    $result = Clipbucket_db::getInstance()->select(tbl('editors_picks'), 'sort', null, null, ' sort DESC ');
    return $result[0]['sort'];
}

/**
 * @throws Exception
 */
function video_manager_ep_link($vid): string
{
    if (is_video_in_editors_pick($vid['videoid'])) {
        return '<li><a role="menuitem" tabindex="-1" href="' . queryString(null, ['remove_editor_pick', 'add_editor_pick', 'mode']) . 'remove_editor_pick=' . $vid['videoid'] . '">' . lang('plugin_editors_picks_remove_from') . '</a><li>';
    }
    return '<li><a role="menuitem" tabindex="-1" href="' . queryString(null, ['remove_editor_pick', 'add_editor_pick', 'mode']) . 'add_editor_pick=' . $vid['videoid'] . '">' . lang('plugin_editors_picks_add_to') . '</a></li>';
}

/**
 * @throws Exception
 */
function get_ep_videos(): array
{
    return Clipbucket_db::getInstance()->select(tbl('editors_picks,video,users'), tbl('editors_picks.*,video.*,users.userid,users.username as user_username'), ' ' . tbl('editors_picks') . '.videoid = ' . tbl('video') . '.videoid AND ' . tbl('video.active') . ' = \'yes\' AND ' . tbl('video.broadcast') . ' = \'public\' AND ' . tbl('video.userid') . ' = ' . tbl('users.userid') . ' ORDER BY ' . tbl('editors_picks') . '.sort ASC');
}

/**
 * @throws Exception
 */
function move_epick($id, $order)
{
    if (!is_video_in_editors_pick($id)) {
        e('Video doesn\'t exist in editor\'s picks');
    } else {
        if (!is_numeric($order) || $order < 1) {
            $order = 1;
        }
        Clipbucket_db::getInstance()->update(tbl('editors_picks'), ['sort'], [$order], ' videoid=\'' . $id . '\'');
    }
}

/**
 * @throws Exception
 */
function admin_area_tab($vid): string
{
    if (is_video_in_editors_pick($vid['videoid'])) {
        return '<span class="label label-info">' . lang('plugin_editors_picks') . '</span>';
    }
    return '';
}

/**
 * @throws Exception
 */
function display_editors_pick()
{
    assign('editor_picks', get_ep_videos());
    echo Fetch(DirPath::get('plugins') . 'editors_pick/templates/front/editorspicks.html', true);
}

global $cbvid;

//Adding Editor's Pick Link
$cbvid->video_manager_link[] = 'video_manager_ep_link';

//Temporary purpose
$cbvid->video_manager_link_new[] = 'admin_area_tab';

//Calling Editor Picks Function
$cbvid->video_manager_funcs[] = 'editors_pick';

$min_suffixe = in_dev() ? '' : '.min';
ClipBucket::getInstance()->addJS(['editors_pick/assets/js/editors_pick' . $min_suffixe . '.js' => 'plugin']);
ClipBucket::getInstance()->addCSS(['editors_pick/assets/css/themes/default' . $min_suffixe . '.css' => 'plugin']);

$filepath = DirPath::get('plugins') . 'editors_pick/assets/css/themes/' . config('default_theme') . $min_suffixe . '.css';
if( config('default_theme') != '' && file_exists($filepath) ){
    ClipBucket::getInstance()->addCSS([
        'editors_pick/assets/css/themes/' . config('default_theme') . $min_suffixe . '.css' => 'plugin'
    ]);
}

register_anchor_function('display_editors_pick', 'global');
register_action_remove_video('remove_vid_editors_pick');

add_admin_menu(lang('manage_x', strtolower(lang('plugins'))), strtolower(lang('plugin_editors_picks')), DirPath::getUrl('plugins') . 'editors_pick/admin/editor_pick.php');
