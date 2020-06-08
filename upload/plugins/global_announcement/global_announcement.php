<?php
/*
    Plugin Name: Global announcement
    Description: This will let you post a global announcement on your website
    Author: Arslan Hassan & MacWarrior
    ClipBucket Version: CB5.4
    Website: https://github.com/MacWarrior/clipbucket-v5/
*/

function global_announcement()
{
    global $db;
    $results = $db->select(tbl('global_announcement'),'*');
    $ann = $results[0]['announcement'];
    if (!$ann ==''){
        echo '<div class="alert alert-info margin-bottom-10 ">'.$ann.'</div>';
    }
}

function get_announcement()
{
    global $db;
    $exec = $db->Execute('SELECT * FROM '.tbl("global_announcement"));
    $ann = $exec->getrows();
    return $ann[0][0];
}

function update_announcement($text)
{
    global $db;
    $textCheck = str_replace(array('<p>','</p>','<br>'), '', $text);
    if (strlen($textCheck) < 1) {
        $text = '';
    }
    $db->Execute("UPDATE ".tbl("global_announcement")." SET announcement='$text'");
}

global $Smarty;
$Smarty->register_function('get_announcement','get_announcement');

register_anchor_function('global_announcement','global');

add_admin_menu('Plugin Manager','Announcement',PLUG_URL.'/global_announcement/edit_announcement.php');
