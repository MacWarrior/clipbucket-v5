<?php
define('THIS_PAGE', 'upgrade_db');
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

if (!NEED_UPDATE) {
    redirect_to('index.php');
}

userquery::getInstance()->admin_login_check();

$breadcrumb[0] = ['title' => 'Dashboard', 'url' => ''];
$breadcrumb[1] = ['title' => 'DB Upgrade', 'url' => DirPath::getUrl('admin_area') . 'upgrade_db.php'];

assign('no_version', true);
$revisions = getRevisions();
assign('versions', array_keys($revisions));
assign('revisions', $revisions);

template_files('upgrade_db.html');
display_it();
