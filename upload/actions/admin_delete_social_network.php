<?php
define('THIS_PAGE', 'update_phrase');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (!User::getInstance()->hasAdminAccess()) {
    return false;
}

$id_social_networks_link = $_POST['id_social_networks_link'];

echo SocialNetworks::getInstance()->delete($id_social_networks_link);


