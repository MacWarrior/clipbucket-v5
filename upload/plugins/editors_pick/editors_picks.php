<?php
/*
    Plugin Name: ClipBucket Editor's Pick Plugin
    Description: This plugin is used to display Editor's Pick Player On Home Page and also let you pick videos for editor's pick
    Author: Arslan Hassan & MacWarrior
    ClipBucket Version: CB5.5.0
    Website: https://github.com/MacWarrior/clipbucket-v5/
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

function add_to_editor_pick($vid)
{
    global $cbvid, $db;
    if ($cbvid->video_exists($vid)) {
        if (!is_video_in_editors_pick($vid)) {
            $sort = get_highest_sort_number() + 1;
            $db->insert(tbl('editors_picks'), ['videoid', 'sort', 'date_added'], [$vid, $sort, now()]);
            $db->update(tbl('video'), ['in_editor_pick'], ['yes'], ' videoid = \'' . $vid . '\'');
            e(lang('plugin_editors_picks_added'), 'm');
        } else {
            e(lang('plugin_editors_picks_add_error'), 'e');
        }
    } else {
        e(lang('class_vdo_exist_err'));
    }
}

function remove_vid_editors_pick($vid)
{
    global $db;
    if (is_array($vid)) {
        $vid = $vid['videoid'];
    }
    if (is_video_in_editors_pick($vid)) {
        $db->delete(tbl('editors_picks'), ['videoid'], [$vid]);
        $db->update(tbl('video'), ['in_editor_pick'], ['no'], ' videoid = \'' . $vid . '\'');
        e(lang('plugin_editors_picks_removed'), 'm');
    }
}

function is_video_in_editors_pick($vid): bool
{
    global $db;
    $count = $db->count(tbl('editors_picks'), 'videoid', ' videoid = \'' . $vid . '\'');
    if ($count > 0) {
        return true;
    }
    return false;
}

function get_highest_sort_number()
{
    global $db;
    $result = $db->select(tbl('editors_picks'), 'sort', null, null, ' sort DESC ');
    return $result[0]['sort'];
}

function video_manager_ep_link($vid): string
{
    if (is_video_in_editors_pick($vid['videoid'])) {
        return '<li><a role="menuitem" tabindex="-1" href="' . queryString(null, ['remove_editor_pick', 'add_editor_pick', 'mode']) . 'remove_editor_pick=' . $vid['videoid'] . '">' . lang('plugin_editors_picks_remove_from') . '</a><li>';
    }
    return '<li><a role="menuitem" tabindex="-1" href="' . queryString(null, ['remove_editor_pick', 'add_editor_pick', 'mode']) . 'add_editor_pick=' . $vid['videoid'] . '">' . lang('plugin_editors_picks_add_to') . '</a></li>';
}

function get_ep_videos(): array
{
    global $db;
    return $db->select(tbl('editors_picks,video,users'), tbl('editors_picks.*,video.*,users.userid,users.username'), ' ' . tbl('editors_picks') . '.videoid = ' . tbl('video') . '.videoid AND ' . tbl('video.active') . ' = \'yes\' AND ' . tbl('video.broadcast') . ' = \'public\' AND ' . tbl('video.userid') . ' = ' . tbl('users.userid') . ' ORDER BY ' . tbl('editors_picks') . '.sort ASC');
}

function move_epick($id, $order)
{
    global $db;
    if (!is_video_in_editors_pick($id)) {
        e("Video doesnt exist in editor's picks");
    } else {
        if (!is_numeric($order) || $order < 1) {
            $order = 1;
        }
        $db->update(tbl('editors_picks'), ['sort'], [$order], ' videoid=\'' . $id . '\'');
    }
}

function admin_area_tab($vid): string
{
    if (is_video_in_editors_pick($vid['videoid'])) {
        return '<span class="label label-info">' . lang('plugin_editors_picks') . '</span>';
    }
    return '';
}

function display_editors_pick()
{
    assign('editor_picks', get_ep_videos());
    echo Fetch(PLUG_DIR . '/editors_pick/templates/front/editorspicks.html', true);
}

global $cbvid;

//Adding Editor's Pick Link
$cbvid->video_manager_link[] = 'video_manager_ep_link';

//Temporary purpose
$cbvid->video_manager_link_new[] = 'admin_area_tab';

//Calling Editor Picks Function
$cbvid->video_manager_funcs[] = 'editors_pick';

if (in_dev()) {
    add_js(['editors_pick/assets/js/editors_pick.js' => 'plugin']);
} else {
    add_js(['editors_pick/assets/js/editors_pick.min.js' => 'plugin']);
}
register_anchor_function('display_editors_pick', 'global');
register_action_remove_video('remove_vid_editors_pick');

if (!NEED_UPDATE) {
    add_admin_menu('Plugin Manager', lang('plugin_editors_picks'), PLUG_URL . '/editors_pick/admin/editor_pick.php');
}
