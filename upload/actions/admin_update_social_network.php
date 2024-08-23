<?php
define('THIS_PAGE', 'update_phrase');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$id_social_networks_link = $_POST['id_social_networks_link'];
$title = $_POST['title'];
$url = $_POST['url'];
$social_network_link_order = $_POST['social_network_link_order'];

SocialNetworks::getInstance()->update($id_social_networks_link, $title, $url, $social_network_link_order);

echo json_encode(SocialNetworks::getInstance()->getOne(['id_social_networks_link'=>$id_social_networks_link]));
