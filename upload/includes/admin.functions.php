<?php
/**
 * All Functions that
 * are used by admin,
 * registered here
 */

//Registering Admin Options for Watch Video
if (has_access('admin_access', true)) {
    function show_video_admin_link($data)
    {
        echo '<a href="' . DirPath::getUrl('admin_area') . 'edit_video.php?video=' . $data['videoid'] . '">Edit Video</a>';
    }

    function show_view_channel_link($data)
    {
        echo '<a href="' . DirPath::getUrl('admin_area') . 'view_user.php?uid=' . $data['userid'] . '">Edit User</a>';
    }

    register_anchor_function('show_video_admin_link', 'watch_admin_options');
    register_anchor_function('show_view_channel_link', 'view_channel_admin_options');
}
