<?php
define('THIS_PAGE', 'update_phrase');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

if( empty($_POST) ){
    return false;
}

if( !isset($_POST['id_social_networks_link']) || !isset($_POST['title']) || !isset($_POST['url']) || !isset($_POST['social_network_link_order']) ){
    return false;
}

$id_social_networks_link = $_POST['id_social_networks_link'];
$title = $_POST['title'];
$url = $_POST['url'];
$social_network_link_order = $_POST['social_network_link_order'];
$id_fontawesome_icon = $_POST['id_fontawesome_icon'];

SocialNetworks::getInstance()->update($id_social_networks_link, $title, $url, (int)$social_network_link_order, (int)$id_fontawesome_icon);

echo json_encode(SocialNetworks::getInstance()->getOne(['id_social_networks_link'=>$id_social_networks_link]));
