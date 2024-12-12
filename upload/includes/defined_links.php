<?php
$cbLinks = [
    'channels'           => ['channels.php', 'channels/'],
    'compose_new'        => ['private_message.php?mode=new_msg', 'private_message.php?mode=new_msg'],
    'contact_us'         => ['contact.php', 'contact'],
    'inbox'              => ['private_message.php?mode=inbox', 'private_message.php?mode=inbox'],
    'login'              => ['signup.php', 'signup.php'],
    'login_success'      => ['login_success.php', 'login_success.php'],
    'logout'             => ['logout.php', 'logout.php'],
    'logout_success'     => ['logout_success.php', 'logout_success.php'],
    'my_account'         => ['myaccount.php', 'my_account'],
    'my_videos'          => ['manage_videos.php', 'manage_videos.php'],
    'my_photos'          => ['manage_photos.php', 'manage_photos.php'],
    'my_favorites'       => ['manage_videos.php?mode=favorites', 'manage_videos.php?mode=favorites'],
    'my_playlists'       => ['manage_playlists.php', 'manage_playlists.php'],
    'my_contacts'        => ['manage_contacts.php', 'manage_contacts.php'],
    'notifications'      => ['private_message.php?mode=notification', 'private_message.php?mode=notification'],
    'rss'                => ["rss.php?mode=", "rss/"],
    'search_result'      => ['search_result.php', 'search_result.php'],
    'signup'             => ['signup.php', 'signup'],
    'upload'             => ['upload.php', 'upload'],
    'user_contacts'      => ['user_contacts.php?user=', 'user_contacts.php?user='],
    'user_subscriptions' => ['user_contacts.php?mode=subscriptions&user=', 'user_contacts.php?mode=subscriptions&user='],
    'user_subscribers'   => ['user_contacts.php?mode=subscribers&user=', 'user_contacts.php?mode=subscribers&user='],
    'user_favorites'     => ['user_videos.php?mode=favorites&user=', 'user_videos.php?mode=favorites&user='],
    'user_videos'        => ['user_videos.php?user=', 'user_videos.php?user='],
    'user_playlists'     => ['user_videos.php?mode=playlists&user='],
    'videos'             => ['videos.php', 'videos/'],
    'messages'           => ['private_message.php', 'private_message.php'],
    'edit_account'       => ['edit_account.php', 'edit_account.php']
];

if (is_array(ClipBucket::getInstance()->links)) {
    ClipBucket::getInstance()->links = array_merge(ClipBucket::getInstance()->links, $cbLinks);
}
