<?php
/*
    Plugin Name: ClipBucket Editor's Pick Plugin
    Description: This plugin is used to display Editor's Pick Player On Home Page and also let you pick videos for editor's pick
    Author: Arslan Hassan & MacWarrior
    ClipBucket Version: CB5.4
    Website: https://github.com/MacWarrior/clipbucket-v5/
*/

function editors_pick()
{
    if($_GET['add_editor_pick']) {
        $vid = mysql_clean($_GET['add_editor_pick']);
        add_to_editor_pick($vid);
    }

    if($_GET['remove_editor_pick']) {
        $vid = mysql_clean($_GET['remove_editor_pick']);
        remove_vid_editors_pick($vid);
    }
}

function add_to_editor_pick($vid)
{
    global $cbvid,$db;
    if($cbvid->video_exists($vid)) {
        if(!is_video_in_editors_pick($vid)) {
            $sort = get_highest_sort_number() + 1 ;
            $db->insert(tbl("editors_picks"),array("videoid","sort","date_added"),array($vid,$sort,now()));
            $db->update(tbl("video"), array("in_editor_pick"), array("yes")," videoid = '".$vid."'");
            e(lang("Video has been added to editor's pick"),"m");
        } else {
            e(lang("Video is already in editor's pick"),"e");
        }
    } else {
        e(lang("video_exist_err"));
    }
}

function remove_vid_editors_pick($vid)
{
    global $db;
    if(is_array($vid)) {
        $vid = $vid['videoid'];
    }
    if(is_video_in_editors_pick($vid)) {
        $db->delete(tbl('editors_picks'),array('videoid'),array($vid));
        $db->update(tbl("video"), array("in_editor_pick"), array("no")," videoid = '".$vid."'");
        e(lang("Video has been removed from editor's pick"),"m");
    }
}

function is_video_in_editors_pick($vid)
{
    global $db;
    $count = $db->count(tbl("editors_picks"),"videoid"," videoid='$vid'");
    if($count>0){
        return true;
    }
    return false;
}

function get_highest_sort_number()
{
    global $db;
    $result = $db->select(tbl("editors_picks"),"sort",NULL,NULL," sort DESC ");
    return $result[0]['sort'];
}

function video_manager_ep_link($vid)
{
    if(is_video_in_editors_pick($vid['videoid'])){
        return '<li><a role="menuitem" tabindex="-1" href="'.queryString(NULL, array('remove_editor_pick','add_editor_pick','mode')).'remove_editor_pick='.$vid['videoid'].'">Remove From Editor\'s Pick</a><li>';
    }
    return '<li><a role="menuitem" tabindex="-1" href="'.queryString(NULL, array('remove_editor_pick','add_editor_pick','mode')).'add_editor_pick='.$vid['videoid'].'">Add To Editor\'s Pick</a></li>';
}

function get_ep_videos()
{
    global $db;
    return $db->select(tbl('editors_picks,video,users'),tbl('editors_picks.*,video.*,users.userid,users.username')," ".tbl('editors_picks').".videoid = ".tbl('video').".videoid AND ".tbl('video.active')." = 'yes' AND ".tbl('video.broadcast')." = 'public' AND ".tbl("video.userid")." = ".tbl("users.userid")." ORDER BY ".tbl('editors_picks').".sort ASC");
}

function move_epick($id,$order)
{
    global $db;
    if(!is_video_in_editors_pick($id)){
        e("Video doesnt exist in editor's picks");
    } else {
        if(!is_numeric($order) || $order <1) {
            $order = 1;
        }
        $db->update(tbl("editors_picks"),array("sort"),array($order)," videoid='".$id."'");
    }
}

function admin_area_tab($vid)
{
    if(is_video_in_editors_pick($vid['videoid'])){
        return '<span class="label label-success">Added to editors pick</span>';
    }
    return '';
}

function display_editors_pick()
{
    assign('editor_picks',get_ep_videos());
    echo Fetch(PLUG_DIR.'/editors_pick/templates/front/editorspicks.html',true);
}

//Adding Editor's Pick Link
$cbvid->video_manager_link[] = 'video_manager_ep_link';

//Temporary purpose
$cbvid->video_manager_link_new[] = 'admin_area_tab';

//Calling Editor Picks Function
$cbvid->video_manager_funcs[] = 'editors_pick';

if( in_dev() ){
    add_js(array('editors_pick/assets/js/editors_pick.js'=>'plugin'));
} else {
    add_js(array('editors_pick/assets/js/editors_pick.min.js'=>'plugin'));
}
register_anchor_function('display_editors_pick','global');
register_action_remove_video('remove_vid_editors_pick');

add_admin_menu('Plugin Manager','Editor\'s Pick',PLUG_URL.'/editors_pick/admin/editor_pick.php');
