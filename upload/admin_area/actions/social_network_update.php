<?php
const THIS_PAGE = 'social_network_update';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!isset($_POST['id_social_networks_link']) || !isset($_POST['title']) || !isset($_POST['url']) || !isset($_POST['social_network_link_order']) || !isset($_POST['id_fontawesome_icon'])) {
    e(lang('missing_params'));
    $success = false;
    $data = [];
} else {
    $id_social_networks_link = $_POST['id_social_networks_link'];
    $title = $_POST['title'];
    $url = $_POST['url'];
    $social_network_link_order = $_POST['social_network_link_order'];
    $id_fontawesome_icon = $_POST['id_fontawesome_icon'];

    $success = SocialNetworks::getInstance()->update($id_social_networks_link, $title, $url, (int)$social_network_link_order, (int)$id_fontawesome_icon);
    $data = SocialNetworks::getInstance()->getOne(['id_social_networks_link' => $id_social_networks_link]);
}

echo json_encode([
    'success' => $success,
    'data'    => $data,
    'msg'     => getTemplateMsg()
]);
