<?php
const THIS_PAGE = 'social_network_delete';
const IS_AJAX = true;
require_once dirname(__FILE__, 3) . '/includes/admin_config.php';

if (!User::getInstance()->hasAdminAccess()) {
    return false;
}

$id_social_networks_link = $_POST['id_social_networks_link'];

echo SocialNetworks::getInstance()->delete($id_social_networks_link);


