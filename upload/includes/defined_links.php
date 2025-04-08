<?php
$cbLinks = [
    'error_403'               => ['403.php', '403'],
    'error_404'               => ['404.php', '404'],

    'sitemap'                 => ['sitemap.php', 'sitemap.xml'],
    'rss'                     => ['rss.php?mode=', 'rss/'],

    'videos'                  => ['videos.php', 'videos/'],
    'channels'                => ['channels.php', 'channels/'],

    'upload'                  => ['upload.php', 'upload'],

    'compose_new'        => ['private_message.php?mode=new_msg', 'private_message.php?mode=new_msg'],
    'contact_us'         => ['contact.php', 'contact'],
    'inbox'              => ['private_message.php?mode=inbox', 'private_message.php?mode=inbox'],
    'login'              => ['signup.php', 'signup.php'],
    'logout'             => ['logout.php', 'logout.php'],
    'my_account'         => ['myaccount.php', 'my_account'],
    'my_videos'          => ['manage_videos.php', 'manage_videos.php'],
    'my_photos'          => ['manage_photos.php', 'manage_photos.php'],
    'my_favorites'       => ['manage_videos.php?mode=favorites', 'manage_videos.php?mode=favorites'],
    'my_playlists'       => ['manage_playlists.php', 'manage_playlists.php'],
    'my_contacts'        => ['manage_contacts.php', 'manage_contacts.php'],
    'notifications'      => ['private_message.php?mode=notification', 'private_message.php?mode=notification'],

    'search_result'      => ['search_result.php', 'search_result.php'],
    'signup'             => ['signup.php', 'signup'],
    'signin'             => ['signup.php?mode=login', 'signin'],


    'messages'           => ['private_message.php', 'private_message.php'],
    'edit_account'       => ['edit_account.php', 'edit_account.php'],
    'view_channel'       => ['view_channel.php', 'user/']
];

if (is_array(ClipBucket::getInstance()->links)) {
    ClipBucket::getInstance()->links = array_merge(ClipBucket::getInstance()->links, $cbLinks);
}
