<?php
define('THIS_PAGE', 'notifications');

require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (
    !(config('videosSection')=='yes' && User::getInstance()->hasPermission('video_moderation'))
    && !(config('photosSection')=='yes' && User::getInstance()->hasPermission('photos_moderation'))
    && !(config('collectionsSection')=='yes' && User::getInstance()->hasPermission('collection_moderation'))
    && !(config('channelsSection')=='yes' && User::getInstance()->hasPermission('member_moderation'))
) {
    sessionMessageHandler::add_message(lang('cannot_access_page'), 'w',  DirPath::getUrl('admin_area', true));
}
/* Generating breadcrumb */
global $breadcrumb;
$breadcrumb[0] = ['title' => lang('general'), 'url' => ''];
$breadcrumb[1] = ['title' => lang('notifications'), 'url' => DirPath::getUrl('admin_area') . 'notifications.php'];

subtitle(lang('notifications'));
template_files('notifications.html');
display_it();
